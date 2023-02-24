### 1. 动画


#### 1.1 状态

##### 1.6.1 什么是状态

状态表示的是要进行运动的元素在运动的不同时期所呈现的样式。

##### 1.6.2 状态的种类

在 Angular 中，有三种类型的状态，分别为：`void`、`*`、`custom`

void：当元素在内存中创建好但尚未被添加到 DOM 中或将元素从 DOM 中删除时会发生此状态

\*：元素被插入到 DOM 树之后的状态，或者是已经在DOM树中的元素的状态，也叫默认状态

custom：自定义状态，元素默认就在页面之中，从一个状态运动到另一个状态，比如面板的折叠和展开。

##### 1.6.3 进出场动画

进场动画是指元素被创建后以动画的形式出现在用户面前，进场动画的状态用 `void => *` 表示，别名为 `:enter`


出场动画是指元素在被删除前执行的一段告别动画，出场动画的状态用 `* => void`，别名为 `:leave`


#### 1.2 快速上手

1. 在使用动画功能之前，需要引入动画模块，即 `BrowserAnimationsModule`

   ```javascript
   import { BrowserAnimationsModule } from "@angular/platform-browser/animations"
   
   @NgModule({
     imports: [BrowserAnimationsModule],
   })
   export class AppModule {}
   ```

2. 默认代码解析，todo 之删除任务和添加任务

   ```html
   <!-- 在 index.html 文件中引入 bootstrap.min.css -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" />
   ```

   ```html
   <div class="container">
     <h2>Todos</h2>
     <div class="form-group">
       <input (keyup.enter)="addItem(input)" #input type="text" class="form-control" placeholder="add todos" />
     </div>
     <ul class="list-group">
       <li (click)="removeItem(i)" *ngFor="let item of todos; let i = index" class="list-group-item">
         {{ item }}
       </li>
     </ul>
   </div>
   ```

   ```javascript
   import { Component } from "@angular/core"
   
   @Component({
     selector: "app-root",
     templateUrl: "./app.component.html",
     styles: []
   })
   export class AppComponent {
     // todo 列表
     todos: string[] = ["Learn Angular", "Learn RxJS", "Learn NgRx"]
   	// 添加 todo
     addItem(input: HTMLInputElement) {
       this.todos.push(input.value)
       input.value = ""
     }
   	// 删除 todo
     removeItem(index: number) {
       this.todos.splice(index, 1)
     }
   }
   ```

3. 创建动画

   1. trigger 方法用于创建动画，指定动画名称
   2. transition 方法用于指定动画的运动状态，出场动画或者入场动画，或者自定义状态动画。
   3. style 方法用于设置元素在不同的状态下所对应的样式
   4. animate 方法用于设置运动参数，比如动画运动时间，延迟事件，运动形式

   ```javascript
   @Component({
     animations: [
       // 创建动画, 动画名称为 slide
       trigger("slide", [
         // 指定入场动画 注意: 字符串两边不能有空格, 箭头两边可以有也可以没有空格
         // void => * 可以替换为 :enter
         transition("void => *", [
           // 指定元素未入场前的样式
           style({ opacity: 0, transform: "translateY(40px)" }),
           // 指定元素入场后的样式及运动参数
           animate(250, style({ opacity: 1, transform: "translateY(0)" }))
         ]),
         // 指定出场动画
         // * => void 可以替换为 :leave
         transition("* => void", [
           // 指定元素出场后的样式和运动参数
           animate(600, style({ opacity: 0, transform: "translateX(100%)" }))
         ])
       ])
     ]
   })
   ```

   ```text
<!-- <li @slide></li> --> 注释了不然编译不通过
   ```
   
   注意：入场动画中可以不指定元素的默认状态，Angular 会将 void 状态清空作为默认状态
   
   ```javascript
   trigger("slide", [
     transition(":enter", [
       style({ opacity: 0, transform: "translateY(40px)" }),
       animate(250)
     ]),
     transition(":leave", [
    		animate(600, style({ opacity: 0, transform: "translateX(100%)" }))
     ])
])
   ```
   
   注意：要设置动画的运动参数，需要将 animate 方法的一个参数更改为字符串类型
   
   ```javascript
   // 动画执行总时间 延迟时间 (可选) 运动形式 (可选)
   animate("600ms 1s ease-out", style({ opacity: 0, transform: "translateX(100%)" }))
   ```

#### 1.3  关键帧动画

关键帧动画使用 `keyframes` 方法定义

```javascript
transition(":leave", [
  animate(
    600,
    keyframes([
      style({ offset: 0.3, transform: "translateX(-80px)" }),
      style({ offset: 1, transform: "translateX(100%)" })
    ])
  )
])
```

#### 1.4 动画回调

Angular 提供了和动画相关的两个回调函数，分别为动画开始执行时和动画执行完成后

```html
<li @slide (@slide.start)="start($event)" (@slide.done)="done($event)"></li>
```

```javascript
import { AnimationEvent } from "@angular/animations"

start(event: AnimationEvent) {
  console.log(event)
}
done(event: AnimationEvent) {
  console.log(event)
}
```

#### 1.5 创建可重用动画

1. 将动画的定义放置在单独的文件中，方便多组件调用。

   ```javascript
   import { animate, keyframes, style, transition, trigger } from "@angular/animations"
   
   export const slide = trigger("slide", [
     transition(":enter", [
       style({ opacity: 0, transform: "translateY(40px)" }),
       animate(250)
     ]),
     transition(":leave", [
       animate(
         600,
         keyframes([
           style({ offset: 0.3, transform: "translateX(-80px)" }),
           style({ offset: 1, transform: "translateX(100%)" })
         ])
       )
     ])
   ])
   ```

   ```javascript
   import { slide } from "./animations"
   
   @Component({
     animations: [slide]
   })
   ```

2. 抽取具体的动画定义，方便多动画调用。

   ```javascript
   import {animate, animation, keyframes, style, transition, trigger, useAnimation} from "@angular/animations"
   
   export const slideInUp = animation([
     style({ opacity: 0, transform: "translateY(40px)" }),
     animate(250)
   ])
   
   export const slideOutLeft = animation([
     animate(
       600,
       keyframes([
         style({ offset: 0.3, transform: "translateX(-80px)" }),
         style({ offset: 1, transform: "translateX(100%)" })
       ])
     )
   ])
   
   export const slide = trigger("slide", [
     transition(":enter", useAnimation(slideInUp)),
     transition(":leave", useAnimation(slideOutLeft))
   ])
   ```

3. 调用动画时传递运动总时间，延迟时间，运动形式

   ```javascript
   export const slideInUp = animation(
     [
       style({ opacity: 0, transform: "translateY(40px)" }),
       animate("{{ duration }} {{ delay }} {{ easing }}")
     ],
     {
       params: {
         duration: "400ms",
         delay: "0s",
         easing: "ease-out"
       }
     }
   )
   ```

   ```javascript
   transition(":enter", useAnimation(slideInUp, {params: {delay: "1s"}}))
   ```


#### 1.6 查询元素执行动画

Angular 中提供了 `query` 方法查找元素并为元素创建动画

```javascript
import { slide } from "./animations"

animations: [
  slide,
  trigger("todoAnimations", [
    transition(":enter", [
      query("h2", [
        style({ transform: "translateY(-30px)" }),
        animate(300)
      ]),
      // 查询子级动画 使其执行
      query("@slide", animateChild())
    ])
  ])
]
```

```html
<div class="container" @todoAnimations>
  <h2>Todos</h2>
  <ul class="list-group">
    <li
      @slide
      (click)="removeItem(i)"
      *ngFor="let item of todos; let i = index"
      class="list-group-item"
    >
      {{ item }}
    </li>
  </ul>
</div>
```

默认情况下，父级动画和子级动画按照顺序执行，先执行父级动画，再执行子级动画，可以使用  `group` 方法让其并行

```javascript
trigger("todoAnimations", [
  transition(":enter", [
    group([
      query("h2", [
        style({ transform: "translateY(-30px)" }),
        animate(300)
      ]),
      query("@slide", animateChild())
    ])
  ])
])
```

#### 1.7 交错动画

Angular 提供了 stagger 方法，在多个元素同时执行同一个动画时，让每个元素动画的执行依次延迟。

```javascript
transition(":enter", [
  group([
    query("h2", [
      style({ transform: "translateY(-30px)" }),
      animate(300)
    ]),
    query("@slide", stagger(200, animateChild()))
  ])
])
```

注意：stagger 方法只能在 query 方法内部使用

#### 1.8 自定义状态动画

Angular 提供了 `state` 方法用于定义状态。

1. 默认代码解析

   ```html
   <div class="container">
     <div class="panel panel-default">
       <div class="panel-heading" (click)="toggle()">
         一套框架, 多种平台, 移动端 & 桌面端
       </div>
       <div class="panel-body">
         <p>
           使用简单的声明式模板，快速实现各种特性。使用自定义组件和大量现有组件，扩展模板语言。在几乎所有的
           IDE 中获得针对 Angular
           的即时帮助和反馈。所有这一切，都是为了帮助你编写漂亮的应用，而不是绞尽脑汁的让代码“能用”。
         </p>
         <p>
           从原型到全球部署，Angular 都能带给你支撑 Google
           大型应用的那些高延展性基础设施与技术。
         </p>
         <p>
           通过 Web Worker 和服务端渲染，达到在如今(以及未来）的 Web
           平台上所能达到的最高速度。 Angular 让你有效掌控可伸缩性。基于
           RxJS、Immutable.js 和其它推送模型，能适应海量数据需求。
         </p>
         <p>
           学会用 Angular
           构建应用，然后把这些代码和能力复用在多种多种不同平台的应用上 ——
           Web、移动 Web、移动应用、原生应用和桌面原生应用。
         </p>
       </div>
     </div>
   </div>
   <style>
     .container {
       margin-top: 100px;
     }
     .panel-heading {
       cursor: pointer;
     }
   </style>
   ```

   ```javascript
   import { Component } from "@angular/core"
   
   @Component({
     selector: "app-root",
     templateUrl: "./app.component.html",
     styles: []
   })
   export class AppComponent {
     isExpended: boolean = false
     toggle() {
       this.isExpended = !this.isExpended
     }
   }
   ```

2. 创建动画

   ```javascript
   trigger("expandCollapse", [
     // 使用 state 方法定义折叠状态元素对应的样式
     state(
       "collapsed",
       style({
         height: 0,
         overflow: "hidden",
         paddingTop: 0,
         paddingBottom: 0
       })
     ),
     // 使用 state 方法定义展开状态元素对应的样式
     state("expanded", style({ height: "*", overflow: "auto" })),
     // 定义展开动画
     transition("collapsed => expanded", animate("400ms ease-out")),
     // 定义折叠动画
     transition("expanded => collapsed", animate("400ms ease-in"))
   ])
   ```

   ```html
   <div class="panel-body" [@expandCollapse]="isExpended ? 'expanded' : 'collapsed'"></div>
   ```

#### 1.9 路由动画

1. 为路由添加状态标识，此标识即为路由执行动画时的自定义状态

   ```javascript
   const routes: Routes = [
     {
       path: "",
       component: HomeComponent,
       pathMatch: "full",
       data: {
         animation: "one" 
       }
     },
     {
       path: "about",
       component: AboutComponent,
       data: {
         animation: "two"
       }
     },
     {
       path: "news",
       component: NewsComponent,
       data: {
         animation: "three"
       }
     }
   ]
   ```

2. 通过路由插座对象获取路由状态标识，并将标识传递给动画的调用者，让动画执行当前要执行的状态是什么

   ``` html
   <div class="routerContainer" [@routerAnimations]="prepareRoute(outlet)">
     <router-outlet #outlet="outlet"></router-outlet>
   </div>
   ```

   ```javascript
   import { RouterOutlet } from "@angular/router"
   
   export class AppComponent {
     prepareRoute(outlet: RouterOutlet) {
       return (
         outlet &&
         outlet.activatedRouteData &&
         outlet.activatedRouteData.animation
       )
     }
   }
   ```

3. 将 routerContainer 设置为相对定位，将它的直接一级子元素设置成绝对定位

   ```css
   /* styles.css */
   .routerContainer {
     position: relative;
   }
   
   .routerContainer > * {
     position: absolute;
     left: 0;
     top: 0;
     width: 100%;
   }
   ```

4. 创建动画

   ```javascript
   trigger("routerAnimations", [
     transition("one => two, one => three, two => three", [
       query(":enter", style({ transform: "translateX(100%)", opacity: 0 })),
       group([
         query(
           ":enter",
           animate(
             "0.4s ease-in",
             style({ transform: "translateX(0)", opacity: 1 })
           )
         ),
         query(
           ":leave",
           animate(
             "0.4s ease-out",
             style({
               transform: "translateX(-100%)",
               opacity: 0
             })
           )
         )
       ])
     ]),
     transition("three => two, three => one, two => one", [
       query(
         ":enter",
         style({ transform: "translateX(-100%)", opacity: 0 })
       ),
       group([
         query(
           ":enter",
           animate(
             "0.4s ease-in",
             style({ transform: "translateX(0)", opacity: 1 })
           )
         ),
         query(
           ":leave",
           animate(
             "0.4s ease-out",
             style({
               transform: "translateX(100%)",
               opacity: 0
             })
           )
         )
       ])
     ])
   ])
   ```

