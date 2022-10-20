# 函数式编程

### 为什么要学习函数式编程

> 函数式编程是非常古老的一个概念，早于第一台计算机的诞生，[函数式编程的历史](https://zhuanlan.zhihu.com/p/24648375?refer=marisa)。

那我们为什么现在还要学函数式编程？
* 函数式编程是随着 React 的流行受到越来越多的关注
* Vue 3也开始拥抱函数式编程
* 函数式编程可以抛弃 this
* 打包过程中可以更好的利用 tree shaking 过滤无用代码
* 方便测试、方便并行处理
* 有很多库可以帮助我们进行函数式开发：lodash、underscore、ramda 

### 什么是函数式编程

函数式编程(Functional Programming, FP)，FP 是编程范式之一，我们常听说的编程范式还有面向过程

编程、面向对象编程。

* 面向对象编程的思维方式：把现实世界中的事物抽象成程序世界中的类和对象，通过封装、继承和

多态来演示事物事件的联系

- 函数式编程的思维方式：把现实世界的事物和事物之间的**联系**抽象到程序世界（对运算过程进行抽象）

  - 程序的本质：根据输入通过某种运算获得相应的输出，程序开发过程中会涉及很多有输入和

    输出的函数

  - x -> f(联系、映射) -> y，y=f(x)

  - **函数式编程中的函数指的不是程序中的函数(****方法****)，而是数学中的函数即映射关系，例如：y=sin(x)，x和y的关系

  - **相同的输入始终要得到相同的输出**(纯函数)

  - 函数式编程用来描述数据(函数)之间的映射

    ```javascript
    // 非函数式
    let num1 = 2
    let num2 = 3
    let sum = num1 + num2
    console.log(sum) 
    // 函数式 
    function add (n1, n2) {
    	return n1 + n2 
    }
    let sum = add(2, 3) 
    console.log(sum)
    ```

    

### 前置知识

* 函数是一等公民

* 高阶函数

* 闭包

### 函数是一等公民

[MDN First-class Function](https://developer.mozilla.org/zh-CN/docs/Glossary/First-class_Function)

* 函数可以存储在变量中

* 函数作为参数

* 函数作为返回值

在 JavaScript 中**函数就是一个普通的对象** (可以通过 new Function() )，我们可以把函数存储到变量/

数组中，它还可以作为另一个函数的参数和返回值，甚至我们可以在程序运行的时候通过 new 

Function('alert(1)') 来构造一个新的函数。

* 把函数赋值给变量

```javascript
// 把函数赋值给变量
let fn = function () {
  console.log('Hello First-class Function') 
}
fn()
// 一个示例
const BlogController = {
  index (posts) { return Views.index(posts) },
  show (post) { return Views.show(post) }, 
  create (attrs) { return Db.create(attrs) }, 
  update (post, attrs) { return Db.update(post, attrs) }, 
  destroy (post) { return Db.destroy(post) } }
// 优化
const BlogController = {
  index: Views.index, 
  show: Views.show, 
  create: Db.create, 
  update: Db.update, 
  destroy: Db.destroy
}
```

* 函数是一等公民是我们后面要学习的高阶函数、柯里化等的基础。

### 什么是高阶函数

* 高阶函数(Higher-order function)
  * 可以把函数作为参数传递给另一个函数
  * 可以把函数作为另一个函数的返回结果

* 函数作为参数

  ```javascript
  // forEach 
  function forEach (array, fn) {
  	for (let i = 0; i < array.length; i++) {
  		fn(array[i]) 
    } 
  }
  ```

  

* 函数作为返回值

  ```javascript
  // once 
  function once (fn) {
    let done = false
    return function () {
      if (!done) {
        done = true
        return fn.apply(this, arguments) 
      } 
    }
  }
  let pay = once(function (money) { 
    console.log(`支付：${money} RMB`) 
  })
  // 只会支付一次 
  pay(5) 
  pay(5) 
  pay(5)
  ```

  

#### **使用高阶函数的意义**

* 抽象可以帮我们屏蔽细节，只需要关注与我们的目标
* 高阶函数是用来抽象通用的问题

```javascript
// 面向过程的方式
let array = [1, 2, 3, 4]
for (let i = 0; i < array.length; i++) {
console.log(array[i]) 
}

// 高阶高阶函数
let array = [1, 2, 3, 4]
forEach(array, item => { console.log(item) })
```

#### **常用高阶函数**

* forEach 

* map 

* fifilter 

* every 

* some 

* fifind/fifindIndex 

* reduce 

* sort 
* ......

### **闭包**

* 闭包 (Closure)：函数和其周围的状态(词法环境)的引用捆绑在一起形成闭包。
  * 可以在另一个作用域中调用一个函数的内部函数并访问到该函数的作用域中的成员

```javascript
// 函数作为返回值
function makeFn () {
  let msg = 'Hello function' return function () {
    console.log(msg) 
  } 
}
const fn = makeFn() 
fn()
```

* 闭包的本质：函数在执行的时候会放到一个执行栈上当函数执行完毕之后会从执行栈上移除，**但是**

  **堆上的作用域成员因为被外部引用不能释放**，因此内部函数依然可以访问外部函数的成员

* 闭包案例

```javascript
// 生成计算数字的多少次幂的函数
function makePower (power) {
  return function (x) {
    return Math.pow(x, power) 
  }
}
let power2 = makePower(2) 
let power3 = makePower(3)
```



### 纯函数

#### **纯函数概念**

* **纯函数：相同的输入永远会得到相同的输出**，而且没有任何可观察的副作用
  * 纯函数就类似数学中的函数(用来描述输入和输出之间的关系)，y = f(x) 

* lodash 是一个纯函数的功能库，提供了对数组、数字、对象、字符串、函数等操作的一些方法
* 数组的 slice 和 splice 分别是：纯函数和不纯的函数
  * slice 返回数组中的指定部分，不会改变原数组
  * splice 对数组进行操作返回该数组，会改变原数组

* 函数式编程不会保留计算中间的结果，所以变量是不可变的（无状态的）
* 我们可以把一个函数的执行结果交给另一个函数去处理

#### **纯函数的好处**

* 可缓存
  * 因为纯函数对相同的输入始终有相同的结果，所以可以把纯函数的结果缓存起来

* 自己模拟一个 memoize 函数

```javascript
function memoize (f) {
  let cache = {}
  return function () {
    let arg_str = JSON.stringify(arguments)
    cache[arg_str] = cache[arg_str] || f.apply(f, arguments) 
    return cache[arg_str] 
  } 
}
```

* 可测试
  * 纯函数让测试更方便

* 并行处理
  * 在多线程环境下并行操作共享的内存数据很可能会出现意外情况
  * 纯函数不需要访问共享的内存数据，所以在并行环境下可以任意运行纯函数 (Web Worker)

### **副作用**

* 纯函数：对于相同的输入永远会得到相同的输出，而且没有任何可观察的**副作用**

```javascript
// 不纯的
let mini = 18
function checkAge (age) {
  return age >= mini 
}
// 纯的(有硬编码，后续可以通过柯里化解决)
function checkAge (age) {
  let mini = 18 
  return age >= mini 
}
```

副作用让一个函数变的不纯(如上例)，纯函数的根据相同的输入返回相同的输出，如果函数依赖于外部

的状态就无法保证输出相同，就会带来副作用。

### **柯里化** **(Haskell Brooks Curry)**

* 使用柯里化解决上一个案例中硬编码的问题

```javascript
function checkAge (age) {
  let min = 18
  return age >= min
}
// 普通纯函数
function checkAge (min, age) {
  return age >= min 
}
checkAge(18, 24) 
checkAge(18, 20) 
checkAge(20, 30)
// 柯里化
function checkAge (min) {
  return function (age) {
    return age >= min 
  } 
}
// ES6 写法 
let checkAge = min => (age => age >= min) 
let checkAge18 = checkAge(18) 
let checkAge20 = checkAge(20) 
checkAge18(24) 
checkAge18(20)
```

* **柯里化** **(Currying)**
  * 当一个函数有多个参数的时候先传递一部分参数调用它（这部分参数以后永远不变）
  * 然后返回一个新的函数接收剩余的参数，返回结果
  * 模拟 _.curry() 的实现

```javascript
function curry (func) {
  return function curriedFn (...args) {
    // 判断实参和形参的个数 
    if (args.length < func.length) {
    	return function () { 
        return curriedFn(...args.concat(Array.from(arguments)))
      } 
  }
  // 实参和形参个数相同，调用 func，返回结果 return func(...args) } }
```

##### 总结

* 柯里化可以让我们给一个函数传递较少的参数得到一个已经记住了某些固定参数的新函数

* 这是一种对函数参数的'缓存'

* 让函数变的更灵活，让函数的粒度更小

* 可以把多元函数转换成一元函数，可以组合使用函数产生强大的功能
