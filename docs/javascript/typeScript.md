# TypeScript 语法



### 原始数据类型

```typescript
const a: string = 'test'
const b: number = 1
const c: boolean = true
const d:void = undefined
cibst e:sysbol = Symbol()
```



### Object 类型

```typescript
const foo: object = {};

const obj: { foo: number } = { foo: 123 };
```



###  数组类型

```typescript
const arr1: Array<number> = [1,2,3];

const arr2:number[] = [1,2,3];


function sum(...args: number[]): number {
    return args.reduce( (prev, cur) => prev + cur, 0)
}

const page = [];
const arr3:number[][] = [[1,2,3]]
const arr4:Array<Array<any>> = [[1,2,3]]
```



### 元组类型

```typescript
const tuple: [number, string] = [11, "keven"];

// const age = tuple[0];
// const name = tuple[1]

const [age, name] = tuple
```



### 枚举类型

```typescript
// const PostStatus = {
//     Draft: 0,
//     UnPublished: 1,
//     published: 2,
// }

// enum PostStatus {
//     Draft= 0,
//     unpublished = 1,
//     published = 2,
// }


enum PostStatus {
    Draft= 0,
    unpublished ,
    published ,
}

// 常量枚举
const enum PostStatus1 {
    Draft= 0,
    unpublished ,
    published ,
}

// enum PostStatus {
//     Draft= "aaa",
//     unpublished = "bbb" ,
//     published = "ccc" ,
// }

// 枚举类型会影响到编译后的结果

const post = {
    title: "Hello TypeScript",
    content: "TypeScript is a typed superset of JavaScript",
    status:"0" // 0 // 1
}
```



### 函数类型

```typescript
function func1(a: number, b: number  = 10, ...rest: number[]): string {
    return "func1";
}

func1(1, 2)
```



### 任意类型

```typescript
function func1(value: any, ...rest: number[]): any {
    return JSON.stringify(value);
}

func1(1, 2, 3, 4, 6);
```



### 接口类型

* 隐式类型推断

```typescript
/**
 * Type Inference 
 * 隐式类型推断
 */

let age = 18;

// age = "123"

let four // 没赋值 隐式推断为 any


```

* 类型断言

```typescript
/**
 * Type Inference
 * 类型断言
 */

export {};

const num = [110,120, 220, 330];

const res = num.find(i => i> 110);

const num1 = res as number;

const num2 = <number> res ;
```

* 接口成员

```typescript
/**
 * interface 接口 可选成员 只读成员 动态成员
 */
interface Post{
    title: string  // 可写逗号 分号分割 或者不用符号
    content: string
    subTitle?: string  // 可选成员  string || undefine
    readonly summary: string
}

function printPost(post: Post) {
    console.log(post.title)
    console.log(post.content)
    console.log(post.subTitle)
}

const hello: Post = {
    title:"hello",
    content:"么西么西",
    subTitle: undefined,
    summary: "none"
}
// hello.title = "111";
// hello.summary = "adasd"

// 动态成员
interface Cache {
    [props: string]: string
}

const cache: Cache = {
    "name": "young",
    // age:1
}
```



### 类

* 基础类

```typescript
class Person {
    name: string
    age: number
    
    constructor(name: string, age: number) {
        this.name = name
        this.age = age
    }

    sayHi(msg: string) {
        console.log(`Im ${this.name},${this.age} years old,${msg}`)
    }
}
```

* 访问修饰符

```typescript
// 类的访问修饰符 public private protected 控制类成员的可访问级别
class Person {
    public name: string // 公有成员 （默认为公有成员）
    private age: number // 私有成员(只允许在此类当中访问该成员)
    protected gender: boolean // 只允许在子类当中访问该成员

    
    constructor(name: string, age: number, gender: boolean) {
        this.name = name
        this.age = age
        this.gender = gender
    }

    sayHi(msg: string) {
        console.log(`Im ${this.name},${this.age} years old,${msg}`)
    }
}

class Student extends Person {
    private constructor(name: string, age: number, gender: boolean) {
        super(name, age, gender)
        console.log(this.gender)
    }

    static create(name: string, age: number) {
        return new Student(name, age)
    }
}
```

* 只读属性

```typescript
class Person {
    public name: string // 公有成员 （默认为公有成员）
    private age: number // 私有成员(只允许在此类当中访问该成员)
    protected readonly gender: boolean // 只允许在子类当中访问该成员

    
    constructor(name: string, age: number, gender: boolean) {
        this.name = name
        this.age = age
        this.gender = gender
    }

    sayHi(msg: string) {
        console.log(`Im ${this.name},${this.age} years old,${msg}`)
    }
}

const tom = new Person('tom', 19, true);
```

* 类与接口

```typescript
nterface Eat {
    eat(food:string): void
}

interface Run {
    run(distance:number): void
}

class Person implements Eat, Run {
    eat(food: string): void {
        console.log(`优雅的进餐:${food}`)
    }

    run(distance: number): void {
        console.log(`直行${distance}米每秒`)
    }
}

class Animal implements Eat, Run  {
    eat(food: string): void {
        console.log(`不优雅的进餐:${food}`)
    }

    run(distance: number) {
        console.log(`爬行${distance}米每秒`)
    }
}
```

* 抽象类

```typescript
// 抽象类 跟接口类似，约定子类中必须要有哪些成员，可以包含一些具体的实现，而接口知识成员的抽象
abstract class Animal {
    eat(food: string) :void {
        console.log(`吃：${food}`)
    }
    abstract run(distance: number): void
}

class Dog extends Animal {
    run(distance:number): void {
        console.log(`跳起来跑了${distance}米`)
    }
}

const d1 = new Dog();
d1.eat('翔');
d1.run(100);
```



### 范型

```typescript
function createNumberArray(length: number, value: number): Array<any> {
    const arr = new Array<number>(length).fill(value)
    return arr
}

const res = createNumberArray(10,1)

console.log(res)

function createArray<T>(length: number, value: T): T[] {
    const arr = new Array<T>(length).fill(value)
    return arr
}
```



### 类型申明

```typescript
// 类型声明


import { camelCase } from 'lodash';


// declare function  camelCase(input: string): string 
    
const res = camelCase('hello typed')

```



### 类型收窄

```typescript
function padLeft(padding: number | string, input: string): string {
    throw new Error("Not implemented yet!");
}

```

