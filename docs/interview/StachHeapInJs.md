# JavaScript 中的栈（Stack）和堆（Heap）详解

## 1. 内存管理基础

### 1.1 栈和堆的基本概念
```javascript
// 栈：存放基本类型和引用地址（快速访问，大小固定）
// 堆：存放引用类型对象（动态分配，大小灵活）

// 基本类型（栈中存储实际值）
let a = 10;      // 数字
let b = 'hello'; // 字符串
let c = true;    // 布尔值
let d = null;    // null
let e;           // undefined
let f = Symbol('id'); // Symbol
let g = 100n;    // BigInt

// 引用类型（栈中存储指针，堆中存储实际对象）
let obj = { name: 'Alice' };     // 对象
let arr = [1, 2, 3];             // 数组
let func = function() {};        // 函数
let date = new Date();           // 日期
```

### 1.2 内存结构图示
```
┌─────────────────────┐     ┌─────────────────────┐
│        栈（Stack）       │     │        堆（Heap）        │
├─────────────────────┤     ├─────────────────────┤
│ 基本类型：实际值       │     │ 引用类型：实际对象       │
│                     │     │                     │
│ a = 10              │     │ {name: "Alice"}     │
│ b = "hello"         │     │ [1, 2, 3]           │
│ obj = 0x0012        ├─────► 0x0012              │
│ arr = 0x0034        ├─────► 0x0034              │
│ func = 0x0056       ├─────► function(){}        │
└─────────────────────┘     └─────────────────────┘
```

## 2. 栈（Stack）的详细机制

### 2.1 栈的特点
```javascript
// 1. 先进后出（LIFO）结构
// 2. 自动分配和释放
// 3. 大小固定（通常较小）
// 4. 访问速度快

function stackDemo() {
  let x = 10;          // 入栈
  let y = 20;          // 入栈
  let z = x + y;       // 计算，结果入栈
  return z;            // 返回值，局部变量出栈
}

// 函数调用栈示例
function first() {
  console.log('first start');
  let a = 1;           // a 入栈
  second();            // 调用 second
  console.log('first end');
  // a 出栈
}

function second() {
  console.log('second start');
  let b = 2;           // b 入栈
  third();             // 调用 third
  console.log('second end');
  // b 出栈
}

function third() {
  console.log('third start');
  let c = 3;           // c 入栈
  console.log('third end');
  // c 出栈
}

first();
// 调用栈顺序：first → second → third
// 返回顺序：third → second → first
```

### 2.2 栈溢出示例
```javascript
// 递归导致栈溢出（Stack Overflow）
function recursiveCall(count) {
  console.log(`深度: ${count}`);
  let data = new Array(1000).fill('x'); // 每次调用占用栈空间
  recursiveCall(count + 1);
}

try {
  recursiveCall(1);
} catch (e) {
  console.log('栈溢出错误:', e.message);
  // RangeError: Maximum call stack size exceeded
}

// 解决方案：尾递归优化（ES6 严格模式）
function tailRecursive(n, total = 0) {
  if (n <= 0) return total;
  return tailRecursive(n - 1, total + n); // 尾调用
}
```

## 3. 堆（Heap）的详细机制

### 3.1 堆的特点
```javascript
// 1. 动态内存分配
// 2. 大小不固定
// 3. 手动或自动垃圾回收
// 4. 访问速度相对较慢

// 对象在堆中分配
let largeObject = {
  data: new Array(1000000).fill('data'), // 大量数据在堆中
  timestamp: Date.now(),
  metadata: {
    id: 'obj-001',
    tags: ['important', 'large']
  }
};

// 数组在堆中分配
let largeArray = [];
for (let i = 0; i < 1000000; i++) {
  largeArray.push({
    id: i,
    value: Math.random()
  });
}
```

### 3.2 堆内存分配示例
```javascript
// 创建对象（堆内存分配）
function createObjects() {
  // 每次调用都在堆中创建新对象
  return {
    id: Math.random(),
    data: 'some data',
    createdAt: new Date()
  };
}

let obj1 = createObjects(); // 堆地址 0x1001
let obj2 = createObjects(); // 堆地址 0x1002
let obj3 = obj1;            // 引用同一个堆地址 0x1001

console.log(obj1 === obj2); // false（不同堆地址）
console.log(obj1 === obj3); // true（相同堆地址）
```

## 4. 值传递 vs 引用传递

### 4.1 基本类型（值传递）
```javascript
// 基本类型：复制值
let a = 10;
let b = a;  // b 复制 a 的值
b = 20;     // 修改 b 不影响 a

console.log(a); // 10
console.log(b); // 20

// 函数参数传递（值传递）
function modifyValue(val) {
  val = 100;  // 修改局部变量
  return val;
}

let num = 50;
let result = modifyValue(num);
console.log(num);    // 50（原始值不变）
console.log(result); // 100
```

### 4.2 引用类型（引用传递）
```javascript
// 引用类型：复制引用地址
let obj1 = { name: 'Alice', age: 25 };
let obj2 = obj1;  // obj2 复制 obj1 的引用地址

obj2.age = 30;    // 通过 obj2 修改堆中的对象
console.log(obj1.age); // 30（obj1 也受到影响）

// 函数参数传递（引用传递）
function modifyObject(obj) {
  obj.age = 40;  // 修改堆中的对象
  obj = { name: 'Bob' }; // 重新赋值，不影响原引用
}

let person = { name: 'Alice', age: 25 };
modifyObject(person);
console.log(person); // {name: 'Alice', age: 40}
```

## 5. 内存生命周期

### 5.1 分配 → 使用 → 释放
```javascript
// 1. 分配内存
function allocateMemory() {
  // 基本类型在栈中分配
  let num = 42;
  
  // 引用类型在堆中分配
  let obj = {
    data: new Array(1000),
    metadata: { id: 1 }
  };
  
  return { num, obj };
}

// 2. 使用内存
let result = allocateMemory();
console.log(result.num);
console.log(result.obj.data.length);

// 3. 释放内存（自动垃圾回收）
result = null; // 不再引用，等待 GC 回收
```

### 5.2 垃圾回收机制
```javascript
// 引用计数法（早期，有循环引用问题）
function referenceCountingIssue() {
  let objA = { name: 'A' };
  let objB = { name: 'B' };
  
  objA.ref = objB;  // objB 引用计数: 1
  objB.ref = objA;  // objA 引用计数: 1
  
  // 即使函数结束，引用计数不为 0，内存泄漏
}

// 标记清除法（现代浏览器使用）
function markAndSweep() {
  let obj = { data: 'large data' };
  // 从根（全局对象）开始标记可达对象
  // 清除不可达对象
  obj = null; // 成为不可达对象，会被回收
}
```

## 6. 内存泄漏示例与避免

### 6.1 常见的内存泄漏
```javascript
// 1. 意外的全局变量
function createLeak1() {
  leak = 'I am a global variable'; // 没有 var/let/const
  this.leak2 = 'I am also global'; // 在非严格模式下
}

// 2. 遗忘的定时器
function createLeak2() {
  let data = new Array(1000000).fill('data');
  setInterval(() => {
    console.log(data.length); // data 一直被引用
  }, 1000);
  
  // 即使不再需要，定时器仍持有 data 引用
}

// 3. DOM 引用
function createLeak3() {
  let elements = {
    button: document.getElementById('button'),
    data: new Array(100000).fill('large data')
  };
  
  // 即使从 DOM 移除，JS 仍持有引用
  document.body.removeChild(elements.button);
  // elements.button 仍引用 DOM 元素
}

// 4. 闭包
function createLeak4() {
  let largeData = new Array(1000000).fill('data');
  
  return function() {
    console.log('闭包引用着 largeData');
    // largeData 不会被释放
  };
}
```

### 6.2 避免内存泄漏的最佳实践
```javascript
// 1. 及时清除引用
function cleanReferences() {
  let data = new Array(1000000).fill('data');
  
  // 使用完后清除引用
  const processData = () => {
    console.log(data.length);
  };
  
  processData();
  data = null; // 手动清除引用
}

// 2. 清除事件监听器和定时器
function manageEventListeners() {
  let data = new Array(10000).fill('data');
  let intervalId;
  
  const startMonitoring = () => {
    intervalId = setInterval(() => {
      console.log('Monitoring:', data.length);
    }, 1000);
  };
  
  const stopMonitoring = () => {
    clearInterval(intervalId);
    data = null; // 清除引用
  };
  
  startMonitoring();
  // 不需要时调用 stopMonitoring()
}

// 3. 使用 WeakMap/WeakSet
function useWeakCollections() {
  let largeObject = { data: new Array(1000000) };
  
  // WeakMap 的键是弱引用
  const weakMap = new WeakMap();
  weakMap.set(largeObject, 'some metadata');
  
  // 当 largeObject 在其他地方不再被引用时
  // 它会自动从 WeakMap 中被移除
  largeObject = null;
  
  // WeakSet 也是弱引用
  const weakSet = new WeakSet();
  weakSet.add({ data: 'temporary' });
}
```

## 7. 性能优化技巧

### 7.1 栈优化
```javascript
// 1. 避免深度递归
// ❌ 不好的递归
function factorial(n) {
  if (n <= 1) return 1;
  return n * factorial(n - 1); // 每次调用都保留上下文
}

// ✅ 优化的循环
function factorialOptimized(n) {
  let result = 1;
  for (let i = 2; i <= n; i++) {
    result *= i;
  }
  return result;
}

// 2. 尾递归优化
function tailRecursiveFactorial(n, total = 1) {
  if (n <= 1) return total;
  return tailRecursiveFactorial(n - 1, n * total);
}

// 3. 减少局部变量
function optimizeLocalVars() {
  // ❌ 过多局部变量
  let a = 1, b = 2, c = 3, d = 4, e = 5;
  
  // ✅ 合并变量
  let config = { a: 1, b: 2, c: 3, d: 4, e: 5 };
}
```

### 7.2 堆优化
```javascript
// 1. 对象池模式
class ObjectPool {
  constructor(createFn) {
    this.pool = [];
    this.createFn = createFn;
  }
  
  acquire() {
    return this.pool.pop() || this.createFn();
  }
  
  release(obj) {
    // 重置对象状态
    for (let key in obj) {
      if (obj.hasOwnProperty(key)) {
        delete obj[key];
      }
    }
    this.pool.push(obj);
  }
}

// 使用对象池
const vectorPool = new ObjectPool(() => ({ x: 0, y: 0 }));
let v1 = vectorPool.acquire();
v1.x = 10;
v1.y = 20;
// 使用完后放回池中
vectorPool.release(v1);

// 2. 避免创建临时对象
function avoidTemporaryObjects() {
  // ❌ 创建临时数组
  function sumBad(arr) {
    return arr.map(x => x * 2).filter(x => x > 10).reduce((a, b) => a + b, 0);
  }
  
  // ✅ 单次遍历
  function sumGood(arr) {
    let total = 0;
    for (let i = 0; i < arr.length; i++) {
      const doubled = arr[i] * 2;
      if (doubled > 10) {
        total += doubled;
      }
    }
    return total;
  }
}

// 3. 使用 TypedArray 处理大量数值数据
function useTypedArrays() {
  // 传统数组（堆中对象，较慢）
  const regularArray = new Array(1000000);
  
  // TypedArray（连续内存，更快）
  const typedArray = new Float64Array(1000000);
  
  // 性能对比
  console.time('regular array');
  for (let i = 0; i < 1000000; i++) {
    regularArray[i] = Math.random();
  }
  console.timeEnd('regular array');
  
  console.time('typed array');
  for (let i = 0; i < 1000000; i++) {
    typedArray[i] = Math.random();
  }
  console.timeEnd('typed array');
}
```

## 8. 实际案例分析

### 8.1 深拷贝 vs 浅拷贝
```javascript
// 浅拷贝（只复制引用）
function shallowCopy(obj) {
  return { ...obj }; // 扩展运算符
}

let original = {
  name: 'Alice',
  scores: [90, 85, 95],
  address: { city: 'Beijing', zip: '100000' }
};

let shallow = shallowCopy(original);
shallow.scores.push(100);
shallow.address.city = 'Shanghai';

console.log(original.scores);    // [90, 85, 95, 100] - 被修改！
console.log(original.address.city); // 'Shanghai' - 被修改！

// 深拷贝（递归复制所有层级）
function deepCopy(obj) {
  if (obj === null || typeof obj !== 'object') {
    return obj;
  }
  
  if (obj instanceof Date) {
    return new Date(obj.getTime());
  }
  
  if (obj instanceof Array) {
    return obj.map(item => deepCopy(item));
  }
  
  if (typeof obj === 'object') {
    const copy = {};
    for (let key in obj) {
      if (obj.hasOwnProperty(key)) {
        copy[key] = deepCopy(obj[key]);
      }
    }
    return copy;
  }
}

let deep = deepCopy(original);
deep.scores.push(88);
deep.address.city = 'Guangzhou';

console.log(original.scores);    // [90, 85, 95, 100] - 不变
console.log(original.address.city); // 'Shanghai' - 不变
```

### 8.2 循环引用的处理
```javascript
// 循环引用对象
function createCircularReference() {
  let objA = { name: 'A' };
  let objB = { name: 'B' };
  objA.ref = objB;
  objB.ref = objA;
  return objA;
}

// 安全的深拷贝（处理循环引用）
function safeDeepCopy(obj, hash = new WeakMap()) {
  if (obj === null || typeof obj !== 'object') {
    return obj;
  }
  
  // 检查是否已拷贝过（处理循环引用）
  if (hash.has(obj)) {
    return hash.get(obj);
  }
  
  let copy;
  if (obj instanceof Date) {
    copy = new Date(obj);
  } else if (obj instanceof Array) {
    copy = [];
    hash.set(obj, copy);
    obj.forEach((item, index) => {
      copy[index] = safeDeepCopy(item, hash);
    });
  } else if (typeof obj === 'object') {
    copy = {};
    hash.set(obj, copy);
    for (let key in obj) {
      if (obj.hasOwnProperty(key)) {
        copy[key] = safeDeepCopy(obj[key], hash);
      }
    }
  }
  
  return copy;
}

const circularObj = createCircularReference();
const copied = safeDeepCopy(circularObj);
console.log(copied.ref.ref === copied); // true（保持循环引用结构）
```

## 9. 调试和监控工具

### 9.1 Chrome DevTools 内存分析
```javascript
// 内存快照示例
function createMemorySnapshot() {
  // 创建一些对象
  const objects = [];
  for (let i = 0; i < 10000; i++) {
    objects.push({
      id: i,
      data: new Array(100).fill('data'),
      timestamp: Date.now()
    });
  }
  
  // 模拟内存泄漏
  window.leakedObjects = objects.slice(0, 1000);
  
  return objects;
}

// 使用 Chrome DevTools:
// 1. 打开 Performance 标签页
// 2. 点击录制，执行操作
// 3. 查看内存使用情况
// 4. 使用 Memory 标签页拍快照
```

### 9.2 性能监控 API
```javascript
// 使用 Performance API 监控内存
function monitorMemory() {
  if (performance.memory) {
    const memory = performance.memory;
    console.log('已使用的堆大小:', memory.usedJSHeapSize);
    console.log('堆大小限制:', memory.jsHeapSizeLimit);
    console.log('总堆大小:', memory.totalJSHeapSize);
    
    const usage = (memory.usedJSHeapSize / memory.jsHeapSizeLimit) * 100;
    console.log(`内存使用率: ${usage.toFixed(2)}%`);
  }
}

// 内存压力监听
if ('memory' in performance) {
  setInterval(monitorMemory, 5000);
}

// 内存不足警告
window.addEventListener('memorywarning', () => {
  console.warn('内存不足警告！');
  // 清理缓存，释放内存
  cleanupCache();
});
```

## 10. 面试常见问题

### Q1: JavaScript 中的基本类型和引用类型有什么区别？
**A**: 
- **基本类型**：值存储在栈中，复制时复制值，大小固定
- **引用类型**：值存储在堆中，栈中存储指针，复制时复制指针

### Q2: 什么是浅拷贝和深拷贝？
**A**: 
- **浅拷贝**：只复制第一层属性，嵌套对象仍共享引用
- **深拷贝**：递归复制所有层级，完全独立的对象

### Q3: 如何避免内存泄漏？
**A**: 
1. 及时清除不再需要的引用
2. 使用 WeakMap/WeakSet 处理弱引用
3. 清理事件监听器和定时器
4. 避免意外的全局变量

### Q4: 垃圾回收是如何工作的？
**A**: 
现代浏览器主要使用**标记清除算法**：
1. 从根对象开始标记所有可达对象
2. 清除未被标记的对象
3. 使用增量标记和分代回收优化性能

### Q5: 栈溢出是什么？如何避免？
**A**: 
- **栈溢出**：调用栈超过最大限制，通常由深度递归引起
- **避免方法**：使用循环代替递归，使用尾递归优化，减少局部变量

## 总结

### 关键点总结：
1. **栈**：存放基本类型和函数调用上下文，LIFO 结构，自动管理
2. **堆**：存放引用类型对象，动态分配，垃圾回收管理
3. **值传递**：基本类型复制值，互不影响
4. **引用传递**：引用类型复制指针，共享对象
5. **内存泄漏**：由未释放的引用引起，需要主动管理
6. **性能优化**：合理使用栈和堆，避免不必要的对象创建

### 最佳实践：
1. 优先使用基本类型，减少堆分配
2. 及时清理不再需要的引用
3. 使用对象池复用对象
4. 避免深度递归和大量局部变量
5. 使用性能工具监控内存使用

理解栈和堆的工作原理对于编写高性能、无内存泄漏的 JavaScript 应用至关重要。
