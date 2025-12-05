# JavaScript 类型转换详解

## 强制类型转换（显式转换）

### 1. `Number()` - 转换为数字

```javascript
// 字符串转数字
console.log(Number("123"));     // 123
console.log(Number("12.34"));   // 12.34
console.log(Number("123abc"));  // NaN（不是数字）

// 布尔值转数字
console.log(Number(true));      // 1
console.log(Number(false));     // 0

// null 和 undefined
console.log(Number(null));      // 0
console.log(Number(undefined)); // NaN

// 特殊值
console.log(Number(""));        // 0
console.log(Number(" "));       // 0（空字符串或空格）

// 数组
console.log(Number([]));        // 0
console.log(Number([1]));       // 1（数组只有一个元素时）
console.log(Number([1, 2]));    // NaN（数组有多个元素）

// 对象
console.log(Number({}));        // NaN
```

### 2. `String()` - 转换为字符串

```javascript
// 数字转字符串
console.log(String(123));       // "123"
console.log(String(12.34));     // "12.34"
console.log(String(Infinity));  // "Infinity"
console.log(String(NaN));       // "NaN"

// 布尔值转字符串
console.log(String(true));      // "true"
console.log(String(false));     // "false"

// null 和 undefined
console.log(String(null));      // "null"
console.log(String(undefined)); // "undefined"

// 数组和对象
console.log(String([]));        // ""
console.log(String([1, 2, 3])); // "1,2,3"
console.log(String({}));        // "[object Object]"
console.log(String({name: "Alice"})); // "[object Object]"

// 函数
console.log(String(function() {})); // "function() {}"
```

### 3. `Boolean()` - 转换为布尔值

```javascript
// 假值（falsy values）转为 false
console.log(Boolean(false));    // false
console.log(Boolean(0));        // false
console.log(Boolean(-0));       // false
console.log(Boolean(0n));       // false（BigInt 0）
console.log(Boolean(""));       // false
console.log(Boolean(null));     // false
console.log(Boolean(undefined));// false
console.log(Boolean(NaN));      // false

// 真值（truthy values）转为 true
console.log(Boolean(true));     // true
console.log(Boolean(1));        // true
console.log(Boolean(-1));       // true
console.log(Boolean(42));       // true
console.log(Boolean("0"));      // true（非空字符串）
console.log(Boolean("false"));  // true
console.log(Boolean(" "));      // true（空格也算非空字符串）
console.log(Boolean([]));       // true
console.log(Boolean({}));       // true
console.log(Boolean(function(){})); // true
```

### 其他常用的强制转换方法

```javascript
// parseInt() - 字符串转整数
console.log(parseInt("123"));     // 123
console.log(parseInt("12.34"));   // 12
console.log(parseInt("123abc"));  // 123（能解析的部分）
console.log(parseInt("abc123"));  // NaN
console.log(parseInt("101", 2));  // 5（二进制转十进制）

// parseFloat() - 字符串转浮点数
console.log(parseFloat("12.34")); // 12.34
console.log(parseFloat("12.34abc")); // 12.34

// 一元加号运算符（+）
console.log(+"123");     // 123
console.log(+"12.34");   // 12.34
console.log(+true);      // 1
console.log(+false);     // 0
console.log(+"abc");     // NaN

// toString()
console.log((123).toString());      // "123"
console.log((true).toString());     // "true"
console.log(([1,2,3]).toString());  // "1,2,3"
console.log(({name: "Alice"}).toString()); // "[object Object]"

// !! 运算符（转换为布尔值）
console.log(!!1);        // true
console.log(!!0);        // false
console.log(!!"hello");  // true
console.log(!!"");       // false
```

## 隐式类型转换（自动转换）

### 1. 字符串拼接时的隐式转换（+ 运算符）

```javascript
// 当 + 运算符的一个操作数是字符串时，另一个会被转换为字符串
console.log("结果是: " + 123);          // "结果是: 123"
console.log("值是: " + true);           // "值是: true"
console.log("数据: " + null);           // "数据: null"
console.log("对象: " + {name: "Alice"}); // "对象: [object Object]"

// 注意运算顺序
console.log(1 + 2 + "3");  // "33"（先计算 1+2=3，然后 3+"3"）
console.log("1" + 2 + 3);  // "123"（从左到右计算，"1"+2="12"，"12"+3="123"）

// 数组和对象的字符串转换
console.log([] + 1);        // "1"（[] 转为 ""）
console.log([1, 2] + 3);    // "1,23"
console.log({} + []);       // "[object Object]"
console.log({} + "test");   // "[object Object]test"
```

### 2. 比较运算时的隐式转换（== 运算符）

```javascript
// == 会进行类型转换，=== 不会
console.log(123 == "123");     // true（字符串转数字）
console.log(1 == true);        // true（true 转 1）
console.log(0 == false);       // true（false 转 0）
console.log(0 == "");          // true（"" 转 0）
console.log(0 == " ");         // true（" " 转 0）
console.log(null == undefined);// true（特殊情况）
console.log(null == 0);        // false（null 不转 0）
console.log(undefined == 0);   // false（undefined 不转 0）

// 特殊情况
console.log([] == ![]);        // true（![] 为 false，false 转 0，[] 转 0）
console.log([] == 0);          // true
console.log([1] == 1);         // true
console.log([1, 2] == "1,2");  // true

// 对象比较
console.log({} == {});         // false（引用比较）
console.log({} == "[object Object]"); // true

// 其他比较运算符也会转换
console.log("10" > 9);         // true（字符串转数字）
console.log(true > false);     // true（true=1, false=0）
console.log("2" > "10");       // true（字符串比较，字符"2" > "1"）
```

### 3. 其他隐式转换场景

```javascript
// 逻辑运算中的隐式转换
console.log(5 && "hello");    // "hello"（真值返回最后一个真值）
console.log(0 || "default");  // "default"（假值返回最后一个假值或第一个真值）
console.log(!0);              // true（0 转为 false，然后取反）
console.log(!"hello");        // false（非空字符串转为 true，然后取反）

// if 条件语句
if (0) { console.log("不会执行"); }
if (1) { console.log("会执行"); }
if ("") { console.log("不会执行"); }
if ("hello") { console.log("会执行"); }

// 算术运算符（除了 +）
console.log("10" - 5);        // 5（字符串转数字）
console.log("10" * "2");      // 20（字符串转数字）
console.log("10" / "2");      // 5（字符串转数字）
console.log("10" - "abc");    // NaN（无法转换）
console.log(true + true);     // 2（布尔值转数字）

// 一元减号运算符
console.log(-"10");           // -10
console.log(-true);           // -1
console.log(-false);          // -0
```

### 4. 对象到原始值的转换规则

```javascript
const obj = {
  value: 10,
  toString() {
    return "Object with value " + this.value;
  },
  valueOf() {
    return this.value;
  }
};

// 隐式转换调用顺序：
console.log(obj + 5);        // 15（先调用 valueOf()）
console.log(String(obj));    // "Object with value 10"（调用 toString()）

// 如果对象没有定义这些方法：
const simpleObj = { value: 10 };
console.log(simpleObj + 5);  // "[object Object]5"（默认 toString()）
console.log(simpleObj - 5);  // NaN
```

## 总结对比

| 转换类型 | 方法/场景 | 示例 | 结果 |
|---------|----------|------|------|
| **强制转换** | Number() | `Number("123")` | 123 |
| **强制转换** | String() | `String(123)` | "123" |
| **强制转换** | Boolean() | `Boolean(0)` | false |
| **隐式转换** | 字符串拼接 | `"num: " + 123` | "num: 123" |
| **隐式转换** | 宽松相等 | `123 == "123"` | true |
| **隐式转换** | 算术运算 | `"10" - 5` | 5 |

## 最佳实践建议

1. **使用 === 而非 ==** 避免隐式转换带来的意外
   ```javascript
   // 推荐
   if (value === 0) { /* ... */ }
   
   // 不推荐
   if (value == 0) { /* ... */ }
   ```

2. **显式转换更清晰**
   ```javascript
   // 明确意图
   const num = Number(input);
   const str = String(value);
   const bool = Boolean(flag);
   ```

3. **注意特殊值转换**
   ```javascript
   console.log(Number(null));      // 0
   console.log(Number(undefined)); // NaN
   console.log(Number(""));        // 0
   console.log(Number("  "));      // 0
   ```

4. **了解对象转换规则**
   ```javascript
   // 可以通过重写 toString() 和 valueOf() 控制对象转换
   class CustomNumber {
     constructor(value) {
       this.value = value;
     }
     valueOf() {
       return this.value;
     }
     toString() {
       return `CustomNumber(${this.value})`;
     }
   }
   ```

理解类型转换机制对于避免 JavaScript 中的常见错误非常重要，特别是在处理用户输入、API 数据和类型判断时。
