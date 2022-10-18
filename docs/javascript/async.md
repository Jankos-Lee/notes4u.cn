# 异步编程

### 同步模式

```javascript
console.log('global begin')
function bar () {
console.log('bar task') }
function foo () {
console.log('foo task')
bar()
}
foo()
console.log('global end')
```

