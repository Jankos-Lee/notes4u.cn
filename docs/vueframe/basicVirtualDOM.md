### Vue VirtualDOM

---

##### 什么是虚拟 DOM

Virtual DOM(虚拟 DOM)，是由普通的 JS 对象来描述 DOM 对象 



##### 为什么要使用虚拟 DOM

* MVVM 框架解决视图和状态同步问题
* 模板引擎可以简化视图操作，没办法跟踪状态
* 虚拟 DOM 跟踪状态变化

* [使用虚拟 DOM 动机](https://github.com/Matt-Esch/virtual-dom)
  * 虚拟 DOM 可以维护程序的状态，跟踪上一次的状态
  * 通过比较前后两次状态差异更新真实 DOM



##### 虚拟 DOM 的作用

* 维护视图和状态的关系
* 复杂视图情况下提升渲染性能
* 跨平台
  * 浏览器平台渲染DOM
  * 服务端渲染 SSR(Nuxt.js/Next.js) 
  * 原生应用(Weex/React Native) 
  * 小程序(mpvue/uni-app)等



##### 虚拟 DOM 库 

###### Snabbdom

* Vue.js 2.x 内部使用的虚拟 DOM 就是改造的 Snabbdom
* 通过模块可扩展
* 源码使用 TypeScript 开发
* 最快的 Virtual DOM 之一



###### virtual-dom



##### Snabbdom 基本使用