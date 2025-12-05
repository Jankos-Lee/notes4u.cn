# JavaScript 原型和原型链详解

## 1. 什么是原型

JavaScript 是一种基于原型的语言，每个对象都有一个原型（prototype）对象，从原型继承属性和方法。

```javascript
// 构造函数
function Person(name, age) {
  this.name = name;
  this.age = age;
}

// 通过原型添加方法
Person.prototype.sayHello = function() {
  console.log(`Hello, my name is ${this.name}`);
};

// 创建实例
const person1 = new Person('Alice', 25);
const person2 = new Person('Bob', 30);

// 调用原型方法
person1.sayHello(); // Hello, my name is Alice
person2.sayHello(); // Hello, my name is Bob
```

## 2. `__proto__` 与 `prototype`

```javascript
function Person(name) {
  this.name = name;
}

Person.prototype.sayHello = function() {
  console.log('Hello');
};

const alice = new Person('Alice');

// __proto__ 指向构造函数的 prototype
console.log(alice.__proto__ === Person.prototype); // true

// prototype 是函数特有的属性
console.log(typeof Person.prototype); // object
console.log(typeof alice.prototype);  // undefined

// constructor 指向构造函数本身
console.log(Person.prototype.constructor === Person); // true
console.log(alice.constructor === Person); // true
```

## 3. 原型链

原型链是 JavaScript 实现继承的机制：

```javascript
// 父类
function Animal(name) {
  this.name = name;
}

Animal.prototype.eat = function() {
  console.log(`${this.name} is eating`);
};

// 子类
function Dog(name, breed) {
  Animal.call(this, name); // 继承属性
  this.breed = breed;
}

// 继承方法（设置原型链）
Dog.prototype = Object.create(Animal.prototype);
Dog.prototype.constructor = Dog;

// 子类特有方法
Dog.prototype.bark = function() {
  console.log(`${this.name} is barking`);
};

// 创建实例
const myDog = new Dog('Buddy', 'Golden Retriever');

// 原型链查找过程：
console.log(myDog.__proto__ === Dog.prototype); // true
console.log(myDog.__proto__.__proto__ === Animal.prototype); // true
console.log(myDog.__proto__.__proto__.__proto__ === Object.prototype); // true
console.log(myDog.__proto__.__proto__.__proto__.__proto__); // null

myDog.eat();  // 从 Animal.prototype 找到
myDog.bark(); // 从 Dog.prototype 找到
```

## 4. 原型链图示

```
myDog
  ↓ __proto__
Dog.prototype
  ↓ __proto__
Animal.prototype
  ↓ __proto__
Object.prototype
  ↓ __proto__
null
```

## 5. 原型链的查找机制

当访问对象的属性或方法时，JavaScript 引擎会：
1. 在对象自身查找
2. 如果找不到，沿着 `__proto__` 到原型对象上查找
3. 继续沿着原型链向上查找，直到 `null`

```javascript
function Parent() {
  this.parentProp = '父类属性';
}

Parent.prototype.parentMethod = function() {
  return '父类方法';
};

function Child() {
  this.childProp = '子类属性';
}

Child.prototype = Object.create(Parent.prototype);
Child.prototype.constructor = Child;
Child.prototype.childMethod = function() {
  return '子类方法';
};

const obj = new Child();

// 查找过程演示
console.log(obj.childProp); // 1. 自身属性中找到
console.log(obj.childMethod()); // 2. 自身没找到，到 Child.prototype 找到
console.log(obj.parentProp); // undefined（注意：属性不会被继承）
console.log(obj.parentMethod()); // 3. 继续到 Parent.prototype 找到
console.log(obj.toString()); // 4. 继续到 Object.prototype 找到
```

## 6. 原型相关的方法

```javascript
// 1. Object.getPrototypeOf()
const obj = {};
console.log(Object.getPrototypeOf(obj) === Object.prototype); // true

// 2. Object.setPrototypeOf()
const proto = { x: 10 };
const obj2 = { y: 20 };
Object.setPrototypeOf(obj2, proto);
console.log(obj2.x); // 10

// 3. Object.create()
const prototypeObj = { greet() { return 'Hello'; } };
const obj3 = Object.create(prototypeObj);
console.log(obj3.greet()); // Hello

// 4. instanceof 运算符
console.log([] instanceof Array); // true
console.log([] instanceof Object); // true
console.log({} instanceof Array); // false

// 5. isPrototypeOf()
console.log(Array.prototype.isPrototypeOf([])); // true
console.log(Object.prototype.isPrototypeOf([])); // true
```

## 7. 实际应用示例

### 7.1 实现继承
```javascript
// ES5 原型继承
function Vehicle(speed) {
  this.speed = speed;
}

Vehicle.prototype.move = function() {
  console.log(`Moving at ${this.speed} km/h`);
};

function Car(speed, brand) {
  Vehicle.call(this, speed);
  this.brand = brand;
}

Car.prototype = Object.create(Vehicle.prototype);
Car.prototype.constructor = Car;
Car.prototype.honk = function() {
  console.log(`${this.brand} honks!`);
};
```

### 7.2 共享方法节省内存
```javascript
// 所有实例共享原型方法，节省内存
function User(name) {
  this.name = name;
  this.id = Math.random(); // 实例属性
}

// 方法放在原型上，所有实例共享
User.prototype.login = function() {
  console.log(`${this.name} logged in`);
};

User.prototype.logout = function() {
  console.log(`${this.name} logged out`);
};

const user1 = new User('Alice');
const user2 = new User('Bob');

// 两个实例共享相同的方法
console.log(user1.login === user2.login); // true
```

### 7.3 扩展内置对象
```javascript
// 扩展数组功能
Array.prototype.last = function() {
  return this[this.length - 1];
};

Array.prototype.first = function() {
  return this[0];
};

const arr = [1, 2, 3, 4];
console.log(arr.first()); // 1
console.log(arr.last());  // 4

// 注意：扩展内置对象可能产生冲突，需谨慎使用
```

## 8. ES6 类语法与原型的关系

```javascript
// ES6 类语法
class Person {
  constructor(name, age) {
    this.name = name;
    this.age = age;
  }
  
  sayHello() {
    console.log(`Hello, I'm ${this.name}`);
  }
}

// 等同于 ES5 的原型写法
function Person(name, age) {
  this.name = name;
  this.age = age;
}

Person.prototype.sayHello = function() {
  console.log(`Hello, I'm ${this.name}`);
};

// 验证
const person = new Person('Alice', 25);
console.log(typeof Person); // function
console.log(person.__proto__ === Person.prototype); // true
```

## 9. 注意事项

1. **性能考虑**：原型链过长会影响查找性能
2. **循环引用**：避免循环原型链（A 的原型是 B，B 的原型又是 A）
3. **属性遮蔽**：实例属性会遮蔽原型上的同名属性
4. **修改原型**：动态修改原型会影响所有已创建的实例

## 总结

原型和原型链是 JavaScript 的核心概念：
- 每个对象都有 `__proto__` 属性指向其原型
- 每个函数都有 `prototype` 属性
- 原型链实现了 JavaScript 的继承机制
- 属性查找沿着原型链向上进行
- ES6 的 class 语法是原型的语法糖

理解原型和原型链对于掌握 JavaScript 的面向对象编程至关重要。
