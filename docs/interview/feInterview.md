# 面试题汇总（2022）

⚠️前言：

项目部分属于自由答题时间，是综合能力的体现，从中可以看出你的思考力（发现问题的能力）、解决问题的能力、逻辑能力、表达能力，是中级、中高级、高级面试中**最重要的环节，没有之一**。该环节没发挥好，最多只能定级为中级。

工程部分考察技术视野、自驱性和执行力，换句话说就是对研发链路的认识。

除了项目和工程部分，其余的问题均属于基础部分，考察面试者基本功是否扎实，基础越牢固，面试官越相信你前面所说的天花乱坠的事情是真实做过的。





## 项目

- 印象深刻的项目
- 攻克的难题

⚠️注意：项目部分在整场面试过程中的半壁江山，因此一定一定一定要在该部分有足够突出的亮点。所面试岗位的定级越高，项目部分占比越重。



## React 面试题

### react【总】

- react 和 vue 的区别？

- class 组件 与 函数组件的区别？

- render 渲染机制

- 为什么使用高阶组件？使用高阶组件的场景？

- 高阶组件、render props、hooks的区别

- 简述react的事件机制

- key在react中的作用 

- 说说对 fiber 结构的理解

- 说说 diff 算法

- react 的生命周期和 vue 的生命周期有哪些不同

- setState到底是异步还是同步?

- 为什么调用 setState 而不是直接改变 state？

- React和Vue的diff算法有何不同

- React必须使用JSX吗？

- 在React中怎么使用async/await？

- 什么是受控组件和非受控组件

- react如何做性能优化

  



### react  class 组件

- react 如何定义事件【只针对于class组件】
- setState 为什么异步的？
- react 的生命周期
- 如何阻止class组件的渲染？
- React中refs的作用是什么？有哪些应用场景？





### react 函数组件 hooks 

- 常用的hooks
- 如何阻止函数组件的子组件渲染？
- hooks 的 使用规则
- react hooks在平时开发中需要注意的问题和原因
- 使用useEffect遇到的问题
- useRef的使用场景





### 数据流

- react 的数据流和vue的数据流有什么区别
- 数据流的发展过程
- 了解redux吗？说说对redux的理解？
- redux有什么缺点
- 如何集成 dva
- dva 集成了哪些东西
- dva 的 API
- dva 的 store 由哪些部分组成
- dva effect 中有哪些常用的 API
- 说说 react-redux，react-redux 支持异步吗
- rudux中connect原理 





### 路由

- React-router的路由有几种模式

- React Router的实现原理是什么？
- 如何配置React-router实现路由切换
- react-router里的标签和标签有什么区别







## 工程化面试题

###  gulp

- gulp 常用命令

  





### webpack

- 如何理解webpack

- webpack的打包流程，如何生成chunk文件

- webpack中loader 和 plugin 的区别

- 常用的webpack 的plugin有哪些？

- 常用的webpack的loader有哪些？

- webpack的热更新原理？ 

- 了解babel吗？babel的原理是什么？

  





### 发版构建流程

- 说一下发版构建的链路流程





### Jenkins

- 如何编写 jenkins 脚本
- jenkins 任务有哪些常见的阶段







### Docker

- 对docker 的理解
- docker 常用命令





### 数据监控——sentry

- 是否查看过 sentry 的日志





## typescript

- 说说对ts的理解

- typescript 中常用的类型声明有哪些

- type 和 interface 的区别

- 什么是声明合并

- 枚举的常用场景

- 什么是泛型

- 是什么是断言？ts中如何实现断言

- never 和 unknown 的区别

  





## 网络和浏览器

### 浏览器

- 从输入URL到页面呈现经历了哪些过程
- 事件循环机制
- 浏览器缓存机制
- 为什么 Javascript 要是单线程的
- 浏览器主要组成部分





### 网络

- 常见的的http code
- 三次握手四次挥手
- HTTPS协议和HTTP协议的区别
- 为什么会发生跨域问题？
- 如何解决跨域问题
- XSS  和 CSRF 攻击
- TCP和UDP的区别



## 性能优化

- 平时项目中通过哪些方式实现性能优化
- 如何分析页面渲染时间？目前页面渲染的级别是毫秒级还是秒极？





## 原生js

- 说说你对面向对象的认识

- 继承的几种方式

- 说说你对闭包的理解

- js的数据类型有哪些

- 手写防抖、节流

- call、bind、apply的区别

- 如何实现bind

- 手写冒泡排序、快速排序

- 深拷贝和浅拷贝的区别

- 深拷贝和浅拷贝的实现方式

- 数组扁平化的方式

- 垃圾回收机制

- JSON.stringify() 可能会有什么样的问题

  



## ES6

- es6 常使用的有哪些
- 实现异步的几种方式
- Promise  有哪些可以直接使用的方法
- promise.all  如何实现
- 使用箭头函数应注意什么？
- 介绍一下 set 和 map 对象
- set对象转换为普通数据的方式
- ES6 中数组的API
- 说说你对 class 的认识
- set Timeout、Promise、async/await 的区别
- symbol 的使用场景
- 手写一个 Promise
- ES2022 新特性
- Symbol 如何使用？Symbol 的应用场景





## axios

- 如何封装axios





## CSS

- 盒模型
- 垂直布局的几种方式





## 团队管理

- 如何把控迭代的进度
- 如何进行 codeReview
- 团队中制定的哪些规范





## 行业

- 说说你对前端的理解
- 说说你对前端行业的认识





## 其他

- 说说你的优缺点
- 最近在学的一门技术
- 如何学习一门新的技术
- 离职原因





## 参考资料

- [js面试之道](http://caibaojian.com/interview-map/frontend/)
- [前端学习PDF汇总](https://github.com/xianshenglu/document)


> 感谢同事总结 meng lin 提供文档 -_-
