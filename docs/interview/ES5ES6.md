# ES5 继承 vs ES6 继承：全面对比

## 1. 核心区别概览

| 特性 | ES5 继承 | ES6 继承 |
|------|----------|----------|
| **语法** | 原型链、构造函数 | `class`、`extends` |
| **本质** | 基于原型的继承 | 语法糖，本质还是原型继承 |
| **可读性** | 较差，代码冗长 | 清晰，类似传统 OOP |
| **内置继承** | 需手动实现 | 原生支持 |
| **静态方法** | 需手动添加 | `static` 关键字 |
| **super 调用** | 无，需手动调用父类构造函数 | `super()` 关键字 |
| **私有属性** | 无原生支持 | `#` 私有字段（ES2022） |
| **constructor** | 普通函数 | 类的构造方法 |
| **方法枚举** | 可枚举（默认） | 不可枚举（默认） |
| **new 调用** | 可省略但危险 | 必须使用 `new` |

## 2. ES5 继承详解

### 2.1 原型链继承
```javascript
// 父类
function Animal(name) {
  this.name = name;
  this.colors = ['red', 'blue'];
}

Animal.prototype.sayName = function() {
  console.log('My name is ' + this.name);
};

// 子类
function Dog(name, age) {
  // 1. 继承属性（构造函数继承）
  Animal.call(this, name); // 调用父类构造函数
  this.age = age;
}

// 2. 继承方法（原型链继承）
Dog.prototype = Object.create(Animal.prototype);

// 3. 修复 constructor 指向
Dog.prototype.constructor = Dog;

// 4. 添加子类方法
Dog.prototype.bark = function() {
  console.log(this.name + ' is barking');
};

// 5. 静态方法（手动添加）
Dog.staticMethod = function() {
  console.log('This is a static method');
};

// 使用
const dog1 = new Dog('Buddy', 3);
dog1.sayName();  // My name is Buddy
dog1.bark();     // Buddy is barking
dog1.colors.push('green');

const dog2 = new Dog('Max', 2);
console.log(dog2.colors); // ['red', 'blue']（不受影响）

Dog.staticMethod(); // This is a static method
```

### 2.2 组合继承的几种方式

```javascript
// 方式1：原型链继承（问题：引用属性共享）
function Parent1() {
  this.names = ['kevin', 'daisy'];
}
function Child1() {}
Child1.prototype = new Parent1();

// 方式2：构造函数继承（问题：方法不能复用）
function Parent2(name) {
  this.name = name;
}
Parent2.prototype.getName = function() {
  return this.name;
};
function Child2(name) {
  Parent2.call(this, name);
}

// 方式3：组合继承（经典，但调用两次父类构造函数）
function Parent3(name) {
  this.name = name;
  this.colors = ['red', 'blue'];
}
Parent3.prototype.getName = function() {
  return this.name;
};
function Child3(name, age) {
  Parent3.call(this, name); // 第二次调用
  this.age = age;
}
Child3.prototype = new Parent3(); // 第一次调用
Child3.prototype.constructor = Child3;

// 方式4：寄生组合继承（最佳ES5方案）
function inheritPrototype(child, parent) {
  // 创建父类原型的副本
  const prototype = Object.create(parent.prototype);
  prototype.constructor = child;
  child.prototype = prototype;
}

function Parent4(name) {
  this.name = name;
}
Parent4.prototype.sayName = function() {
  console.log(this.name);
};

function Child4(name, age) {
  Parent4.call(this, name); // 只调用一次
  this.age = age;
}
inheritPrototype(Child4, Parent4);
```

## 3. ES6 继承详解

### 3.1 Class 基本语法
```javascript
// 父类
class Animal {
  // 构造函数
  constructor(name) {
    this.name = name;
    this.colors = ['red', 'blue'];
  }
  
  // 实例方法
  sayName() {
    console.log(`My name is ${this.name}`);
  }
  
  // 静态方法
  static isAnimal(obj) {
    return obj instanceof Animal;
  }
  
  // Getter
  get description() {
    return `Animal named ${this.name}`;
  }
  
  // Setter
  set nickname(value) {
    this._nickname = value;
  }
}

// 子类
class Dog extends Animal {
  constructor(name, age) {
    // 必须调用 super()，且必须在 this 之前
    super(name);
    this.age = age;
  }
  
  // 重写父类方法
  sayName() {
    super.sayName(); // 调用父类方法
    console.log(`I'm a dog, age ${this.age}`);
  }
  
  // 子类特有方法
  bark() {
    console.log(`${this.name} is barking`);
  }
  
  // 子类静态方法
  static isDog(obj) {
    return obj instanceof Dog;
  }
}

// 使用
const dog = new Dog('Buddy', 3);
dog.sayName();  // My name is Buddy \n I'm a dog, age 3
dog.bark();     // Buddy is barking

console.log(Dog.isAnimal(dog)); // true
console.log(Dog.isDog(dog));    // true
console.log(dog.description);   // Animal named Buddy
```

### 3.2 ES6 继承的新特性

```javascript
// 1. 继承内置类
class CustomArray extends Array {
  // 添加自定义方法
  first() {
    return this[0];
  }
  
  last() {
    return this[this.length - 1];
  }
  
  // 覆盖内置方法
  toString() {
    return `CustomArray: ${super.toString()}`;
  }
}

const arr = new CustomArray(1, 2, 3);
console.log(arr.first());      // 1
console.log(arr.last());       // 3
console.log(arr.toString());   // CustomArray: 1,2,3
console.log(arr instanceof Array); // true

// 2. 继承 null
class NullClass extends null {
  constructor() {
    // 没有 super() 可调用
    return Object.create(NullClass.prototype);
  }
  
  static get [Symbol.species]() {
    return Object;
  }
}

// 3. Mixin 模式
const FlyMixin = BaseClass => class extends BaseClass {
  fly() {
    console.log(`${this.name} is flying`);
  }
};

const SwimMixin = BaseClass => class extends BaseClass {
  swim() {
    console.log(`${this.name} is swimming`);
  }
};

class Bird {
  constructor(name) {
    this.name = name;
  }
}

class Duck extends SwimMixin(FlyMixin(Bird)) {
  quack() {
    console.log(`${this.name} is quacking`);
  }
}

const duck = new Duck('Donald');
duck.fly();   // Donald is flying
duck.swim();  // Donald is swimming
duck.quack(); // Donald is quacking
```

## 4. 底层原理对比

### 4.1 ES5 继承的原型链
```javascript
function ES5Parent() {
  this.parentProp = 'parent';
}
ES5Parent.prototype.parentMethod = function() {};

function ES5Child() {
  ES5Parent.call(this);
  this.childProp = 'child';
}
ES5Child.prototype = Object.create(ES5Parent.prototype);
ES5Child.prototype.constructor = ES5Child;

const es5Instance = new ES5Child();

// 原型链结构：
// es5Instance.__proto__ === ES5Child.prototype
// ES5Child.prototype.__proto__ === ES5Parent.prototype
// ES5Parent.prototype.__proto__ === Object.prototype
// Object.prototype.__proto__ === null

console.log(es5Instance instanceof ES5Child);   // true
console.log(es5Instance instanceof ES5Parent);  // true
console.log(es5Instance instanceof Object);     // true
```

### 4.2 ES6 继承的原型链
```javascript
class ES6Parent {
  constructor() {
    this.parentProp = 'parent';
  }
  parentMethod() {}
}

class ES6Child extends ES6Parent {
  constructor() {
    super();
    this.childProp = 'child';
  }
  childMethod() {}
}

const es6Instance = new ES6Child();

// 原型链结构：
// es6Instance.__proto__ === ES6Child.prototype
// ES6Child.prototype.__proto__ === ES6Parent.prototype
// ES6Parent.prototype.__proto__ === Object.prototype
// Object.prototype.__proto__ === null

// ES6 的额外原型链：
// ES6Child.__proto__ === ES6Parent
// ES6Parent.__proto__ === Function.prototype

console.log(es6Instance instanceof ES6Child);   // true
console.log(es6Instance instanceof ES6Parent);  // true
console.log(es6Instance instanceof Object);     // true
```

## 5. 详细特性对比

### 5.1 构造函数对比
```javascript
// ES5：普通函数
function ES5Constructor(name) {
  this.name = name;
}
ES5Constructor.prototype.getName = function() {
  return this.name;
};

// 可以不用 new 调用（但危险）
const es5Obj = ES5Constructor('Test'); // this 指向全局
console.log(global.name); // 'Test'（污染全局）

// ES6：类的构造方法
class ES6Class {
  constructor(name) {
    this.name = name;
  }
  getName() {
    return this.name;
  }
}

// 必须使用 new 调用
try {
  const es6Obj = ES6Class('Test'); // TypeError
} catch (e) {
  console.log(e.message); // Class constructor cannot be invoked without 'new'
}
```

### 5.2 方法枚举性
```javascript
// ES5：方法默认可枚举
function ES5Func() {}
ES5Func.prototype.method = function() {};
const es5Obj = new ES5Func();

console.log(Object.keys(es5Obj)); // []
for (let key in es5Obj) {
  console.log(key); // 'method'（会被枚举）
}

// ES6：方法默认不可枚举
class ES6Class {
  method() {}
  static staticMethod() {}
}
const es6Obj = new ES6Class();

console.log(Object.keys(es6Obj)); // []
for (let key in es6Obj) {
  console.log(key); // 不会输出 'method'
}

console.log(Object.getOwnPropertyDescriptor(
  ES6Class.prototype, 
  'method'
).enumerable); // false
```

### 5.3 super 关键字的区别
```javascript
// ES5：无 super，需手动调用
function Parent(name) {
  this.name = name;
}
Parent.prototype.sayHello = function() {
  console.log('Hello from Parent');
};

function Child(name, age) {
  // 调用父类构造函数
  Parent.call(this, name);
  this.age = age;
}

Child.prototype.sayHello = function() {
  // 调用父类方法（繁琐）
  Parent.prototype.sayHello.call(this);
  console.log('Hello from Child');
};

// ES6：有 super 关键字
class ParentClass {
  constructor(name) {
    this.name = name;
  }
  
  sayHello() {
    console.log('Hello from Parent');
  }
}

class ChildClass extends ParentClass {
  constructor(name, age) {
    super(name); // 调用父类构造函数
    this.age = age;
  }
  
  sayHello() {
    super.sayHello(); // 调用父类方法
    console.log('Hello from Child');
  }
  
  // super 在静态方法中
  static createChild(name, age) {
    // 调用父类静态方法
    return new super(name);
  }
}
```

### 5.4 静态属性和方法
```javascript
// ES5：需手动添加
function ES5Class() {}
// 静态方法
ES5Class.staticMethod = function() {
  return 'static';
};
// 静态属性
ES5Class.staticProp = 'static prop';

// 不会被实例继承
const es5Instance = new ES5Class();
console.log(es5Instance.staticMethod); // undefined

// ES6：static 关键字
class ES6Class {
  // 静态属性（ES2022）
  static staticProp = 'static prop';
  
  // 静态方法
  static staticMethod() {
    return 'static';
  }
  
  // 静态块（ES2022）
  static {
    console.log('静态代码块执行');
  }
}

// 静态属性和方法不会被实例继承
const es6Instance = new ES6Class();
console.log(es6Instance.staticMethod); // undefined

// 但会被子类继承
class Child extends ES6Class {}
console.log(Child.staticMethod()); // 'static'
console.log(Child.staticProp);     // 'static prop'
```

## 6. 实际应用示例

### 6.1 表单验证系统（ES5 vs ES6）
```javascript
// ES5 实现
function Validator(rules) {
  this.rules = rules;
  this.errors = [];
}

Validator.prototype.validate = function(data) {
  this.errors = [];
  for (let field in this.rules) {
    if (this.rules.hasOwnProperty(field)) {
      const rule = this.rules[field];
      const value = data[field];
      if (!rule(value)) {
        this.errors.push(`${field} 验证失败`);
      }
    }
  }
  return this.errors.length === 0;
};

function EmailValidator() {
  Validator.call(this, {
    email: function(value) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    }
  });
}

EmailValidator.prototype = Object.create(Validator.prototype);
EmailValidator.prototype.constructor = EmailValidator;

// ES6 实现
class ValidatorES6 {
  constructor(rules) {
    this.rules = rules;
    this.errors = [];
  }
  
  validate(data) {
    this.errors = [];
    for (let [field, rule] of Object.entries(this.rules)) {
      const value = data[field];
      if (!rule(value)) {
        this.errors.push(`${field} 验证失败`);
      }
    }
    return this.errors.length === 0;
  }
}

class EmailValidatorES6 extends ValidatorES6 {
  constructor() {
    super({
      email: value => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)
    });
  }
  
  // 可以添加额外功能
  validate(data) {
    const isValid = super.validate(data);
    if (!isValid) {
      console.log('验证失败详情:', this.errors);
    }
    return isValid;
  }
}
```

### 6.2 组件系统设计
```javascript
// ES6 组件系统
class Component {
  constructor(props = {}) {
    this.props = props;
    this.state = {};
  }
  
  setState(newState) {
    this.state = { ...this.state, ...newState };
    this.render();
  }
  
  // 抽象方法
  render() {
    throw new Error('子类必须实现 render 方法');
  }
  
  // 生命周期方法
  componentDidMount() {
    console.log('组件已挂载');
  }
  
  // 静态方法
  static create(element) {
    return new this(element);
  }
}

class Button extends Component {
  constructor(props) {
    super(props);
    this.state = { clicked: false };
  }
  
  handleClick = () => {
    this.setState({ clicked: true });
  };
  
  render() {
    const { text } = this.props;
    const { clicked } = this.state;
    
    console.log(`渲染按钮: ${text}, 点击状态: ${clicked}`);
    return `<button>${clicked ? '已点击' : text}</button>`;
  }
  
  componentDidMount() {
    super.componentDidMount();
    console.log('按钮组件已挂载');
  }
}

// 使用
const button = new Button({ text: '点击我' });
button.render();
button.handleClick();
```

## 7. 转换关系（Babel 编译）

### 7.1 ES6 Class 编译为 ES5
```javascript
// ES6 源码
class Person {
  constructor(name) {
    this.name = name;
  }
  
  sayHello() {
    console.log(`Hello, ${this.name}`);
  }
  
  static create(name) {
    return new Person(name);
  }
}

// Babel 编译后的 ES5 代码
"use strict";

function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}

function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, descriptor.key, descriptor);
  }
}

function _createClass(Constructor, protoProps, staticProps) {
  if (protoProps) _defineProperties(Constructor.prototype, protoProps);
  if (staticProps) _defineProperties(Constructor, staticProps);
  return Constructor;
}

var Person = /*#__PURE__*/function () {
  function Person(name) {
    _classCallCheck(this, Person);
    this.name = name;
  }
  
  _createClass(Person, [{
    key: "sayHello",
    value: function sayHello() {
      console.log("Hello, ".concat(this.name));
    }
  }], [{
    key: "create",
    value: function create(name) {
      return new Person(name);
    }
  }]);
  
  return Person;
}();
```

### 7.2 ES6 继承编译为 ES5
```javascript
// ES6 源码
class Animal {
  constructor(name) {
    this.name = name;
  }
}

class Dog extends Animal {
  constructor(name, age) {
    super(name);
    this.age = age;
  }
}

// Babel 编译后的 ES5 代码
"use strict";

function _inherits(subClass, superClass) {
  if (typeof superClass !== "function" && superClass !== null) {
    throw new TypeError("Super expression must either be null or a function");
  }
  subClass.prototype = Object.create(superClass && superClass.prototype, {
    constructor: {
      value: subClass,
      writable: true,
      configurable: true
    }
  });
  if (superClass) _setPrototypeOf(subClass, superClass);
}

function _setPrototypeOf(o, p) {
  _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
    o.__proto__ = p;
    return o;
  };
  return _setPrototypeOf(o, p);
}

function _createSuper(Derived) {
  return function _createSuperInternal() {
    var Super = _getPrototypeOf(Derived);
    var result;
    if (isNativeReflectConstruct()) {
      var NewTarget = _getPrototypeOf(this).constructor;
      result = Reflect.construct(Super, arguments, NewTarget);
    } else {
      result = Super.apply(this, arguments);
    }
    return _possibleConstructorReturn(this, result);
  };
}

function _possibleConstructorReturn(self, call) {
  if (call && (typeof call === "object" || typeof call === "function")) {
    return call;
  }
  return _assertThisInitialized(self);
}

function _assertThisInitialized(self) {
  if (self === void 0) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }
  return self;
}

function _getPrototypeOf(o) {
  _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
    return o.__proto__ || Object.getPrototypeOf(o);
  };
  return _getPrototypeOf(o);
}

function isNativeReflectConstruct() {
  if (typeof Reflect === "undefined" || !Reflect.construct) return false;
  if (Reflect.construct.sham) return false;
  if (typeof Proxy === "function") return true;
  try {
    Date.prototype.toString.call(Reflect.construct(Date, [], function() {}));
    return true;
  } catch (e) {
    return false;
  }
}

function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}

var Animal = function Animal(name) {
  _classCallCheck(this, Animal);
  this.name = name;
};

var Dog = /*#__PURE__*/function (_Animal) {
  _inherits(Dog, _Animal);
  
  var _super = _createSuper(Dog);
  
  function Dog(name, age) {
    var _this;
    
    _classCallCheck(this, Dog);
    
    _this = _super.call(this, name);
    _this.age = age;
    return _this;
  }
  
  return Dog;
}(Animal);
```

## 8. 兼容性和注意事项

### 8.1 浏览器兼容性
```javascript
// ES6 Class 支持检测
function checkClassSupport() {
  try {
    eval('class Test {}');
    return true;
  } catch (e) {
    return false;
  }
}

// 使用 polyfill 或 Babel 转译
if (!checkClassSupport()) {
  console.log('需要转译 ES6 Class');
  // 使用传统 ES5 实现
}

// 实际开发中应使用：
// 1. Babel 转译
// 2. TypeScript 编译
// 3. Webpack + babel-loader
```

### 8.2 常见陷阱和注意事项
```javascript
// 1. 必须调用 super()
class Parent {
  constructor() {
    this.name = 'parent';
  }
}

class Child extends Parent {
  constructor() {
    // 忘记调用 super()
    // this.age = 10; // ReferenceError
  }
}

// 2. 方法中的 this 问题
class Counter {
  constructor() {
    this.count = 0;
  }
  
  // 错误：箭头函数作为类方法（不推荐）
  increment = () => {
    this.count++;
  };
  
  // 正确：普通方法
  decrement() {
    this.count--;
  }
}

const counter = new Counter();
const { increment, decrement } = counter;
increment(); // 正常工作
decrement(); // TypeError: Cannot read property 'count' of undefined

// 3. 私有字段问题
class WithPrivate {
  #privateField = 'secret';
  
  getPrivate() {
    return this.#privateField;
  }
}

const instance = new WithPrivate();
console.log(instance.getPrivate()); // 'secret'
// console.log(instance.#privateField); // SyntaxError
```

## 9. 性能对比

### 9.1 创建实例性能
```javascript
// 性能测试
function ES5Class(name) {
  this.name = name;
}
ES5Class.prototype.method = function() {
  return this.name;
};

class ES6Class {
  constructor(name) {
    this.name = name;
  }
  method() {
    return this.name;
  }
}

// 测试 ES5
console.time('ES5 创建实例');
for (let i = 0; i < 1000000; i++) {
  new ES5Class('test');
}
console.timeEnd('ES5 创建实例');

// 测试 ES6
console.time('ES6 创建实例');
for (let i = 0; i < 1000000; i++) {
  new ES6Class('test');
}
console.timeEnd('ES6 创建实例');

// 现代浏览器中性能差异很小
// V8 等引擎已优化 class 的性能
```

### 9.2 方法调用性能
```javascript
const es5Instance = new ES5Class('test');
const es6Instance = new ES6Class('test');

// 方法调用测试
console.time('ES5 方法调用');
for (let i = 0; i < 1000000; i++) {
  es5Instance.method();
}
console.timeEnd('ES5 方法调用');

console.time('ES6 方法调用');
for (let i = 0; i < 1000000; i++) {
  es6Instance.method();
}
console.timeEnd('ES6 方法调用');
```

## 10. 总结和选择建议

### 何时使用 ES5 继承：
1. **需要支持旧浏览器**（IE8 及以下）
2. **需要更细粒度的控制**（如修改原型链行为）
3. **特殊继承模式**（如多重继承）
4. **学习原型链原理**时

### 何时使用 ES6 继承：
1. **现代浏览器环境**
2. **团队项目**（可读性更好）
3. **使用 TypeScript**
4. **需要继承内置类**（如 Array、Error）
5. **需要静态方法和属性**
6. **使用私有字段**（ES2022+）

### 迁移建议：
```javascript
// 从 ES5 迁移到 ES6

// ES5 代码
function OldClass(name) {
  this.name = name;
}
OldClass.prototype.sayHello = function() {
  console.log('Hello ' + this.name);
};
OldClass.staticMethod = function() {
  console.log('Static');
};

function OldChild(name, age) {
  OldClass.call(this, name);
  this.age = age;
}
OldChild.prototype = Object.create(OldClass.prototype);
OldChild.prototype.constructor = OldChild;

// ES6 代码
class NewClass {
  constructor(name) {
    this.name = name;
  }
  
  sayHello() {
    console.log(`Hello ${this.name}`);
  }
  
  static staticMethod() {
    console.log('Static');
  }
}

class NewChild extends NewClass {
  constructor(name, age) {
    super(name);
    this.age = age;
  }
}

// 迁移要点：
// 1. 构造函数 → constructor
// 2. 原型方法 → 类方法
// 3. 手动原型链 → extends
// 4. 手动调用父类构造函数 → super()
// 5. 静态方法 → static 关键字
```

### 最佳实践：
1. **新项目优先使用 ES6 Class**
2. **使用 Babel/TypeScript 保证兼容性**
3. **理解底层原型链原理**
4. **合理使用继承，避免过度设计**
5. **考虑组合优于继承**
6. **使用私有字段保护内部状态**

ES6 Class 提供了更清晰、更安全的面向对象编程方式，是现代 JavaScript 开发的首选。但理解其背后的原型链机制对于深入掌握 JavaScript 仍然至关重要。
