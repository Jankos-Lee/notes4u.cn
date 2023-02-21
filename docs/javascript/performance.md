# `JavaScript` 性能优化

> * 内存管理
> * 垃圾回收与常见GC算法
> * V8引擎的垃圾回收

## 内存管理
> Memory Management
 为什么要内存管理

```javascript
    function fn() {
        arr = []
        arr[100000] = 'lg is a coder'
    }
    fn()
```

### JavaScript 中的内存管理
 内存管理介绍：管理开发者主动申请空间、使用空间、释放空间
* 申请空间
* 使用空间
* 释放空间
```javascript
    // 申请
    let obj = {}
    // 使用
    obj.name = 'test'
    // 释放
    obj = null
```
## JavaScript 中的垃圾

### JavaScript 中的垃圾回收
* JavaScript 中的内存管理是自动的
* 对象不在被引用时是垃圾
* 对象不能从根上访问到时是垃圾

### JavaScript 中的可达对象

* 可以访问到的对象就是可达对象（引用、作用域链）
* 可达的标准就是从根出发是否能够被找到
* `JavaScript` 中的根：全局执行上下文

``` JavaScript
    let obj = { name: 'zs' }

    let obj2 = obj

    obj = null // 虽然 obj 置空了，但是存在 obj2 对obj 的引用，obj 依然可达
    // ---------------------

```

> 示例
    ```javascript
    function objGroup(obj1, obj2) {
        obj1.next = obj2
        obj2.prev = obj1
        return {
            o1: obj1,
            o2: obj2
        }
    }

    let obj = objGroup({name: 'obj1'}, {name: 'obj2'})
    // 将 {name: 'obj1'} 变垃圾
    delete obj.obj1
    delete obj.obj2.prev
    // 找到 obj1 {name: 'obj1'} 的路径被删除了，就导致其没有被引用，变成了垃圾。

    ```
 [示例](../../images/demo.png)

### GC里的垃圾