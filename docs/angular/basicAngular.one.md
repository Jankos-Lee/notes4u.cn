## Angular 基础

### 1.  概述

Angular 是一个使用 HTML、CSS、TypeScript 构建客户端应用的框架，用来构建单页应用程序。

Angular 是一个重量级的框架，内部集成了大量开箱即用的功能模块。

Angular 为大型应用开发而设计，提供了干净且松耦合的代码组织方式，使应用程序整洁更易于维护。

[Angular](https://angular.io/)  [Angular 中文](https://angular.cn/)  [Angular CLI](https://cli.angular.io/)

### 2. 架构预览


#### 2.1 模块

Angular 应用是由一个个模块组成的，此模块指的不是ESModule，而是 NgModule 即 Angular 模块。

NgModule 是一组相关功能的集合，专注于某个应用领域，可以将组件和一组相关代码关联起来，是应用组织代码结构的一种方式。

在 Angular 应用中至少要有一个根模块，用于启动应用程序。

NgModule 可以从其它 NgModule 中导入功能，前提是目标 NgModule 导出了该功能。

NgModule 是由 NgModule 装饰器函数装饰的类。

```javascript
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

@NgModule({
  imports: [
    BrowserModule
  ]
})
export class AppModule { }
```

#### 2.2 组件

组件用来描述用户界面，它由三部分组成，组件类、组件模板、组件样式，它们可以被集成在组件类文件中，也可以是三个不同的文件。

组件类用来编写和组件直接相关的界面逻辑，在组件类中要关联该组件的组件模板和组件样式。

组件模板用来编写组件的 HTML 结构，通过数据绑定标记将应用中数据和 DOM 进行关联。

组件样式用来编写组件的组件的外观，组件样式可以采用 CSS、LESS、SCSS、Stylus

在 Angular 应用中至少要有一个根组件，用于应用程序的启动。

组件类是由 Component 装饰器函数装饰的类。

```javascript
import { Component } from "@angular/core"

@Component({
  selector: "app-root",
  templateUrl: "./app.component.html",
  styleUrls: ["./app.component.css"]
})
export class AppComponent {
  title = "angular-test"
}
```

NgModule 为组件提供了编译的上下文环境。

```javascript
import { NgModule } from '@angular/core';
import { AppComponent } from './app.component';

@NgModule({
  declarations: [
    AppComponent
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
```

#### 2.3 服务

服务用于放置和特定组件无关并希望跨组件共享的数据或逻辑。

服务出现的目的在于解耦组件类中的代码，是组件类中的代码干净整洁。

服务是由 Injectable 装饰器装饰的类。

```javascript
import { Injectable } from '@angular/core';

@Injectable({})
export class AppService { }
```

在使用服务时不需要在组件类中通过 new 的方式创建服务实例对象获取服务中提供的方法，以下写法错误，切记切记！！！

```javascript
import { AppService } from "./AppService"

export class AppComponent {
  let appService = new AppService()
}
```

服务的实例对象由 Angular 框架中内置的依赖注入系统创建和维护。服务是依赖需要被注入到组件中。

在组件中需要通过 constructor 构造函数的参数来获取服务的实例对象。

涉及参数就需要考虑参数的顺序问题，因为在 Angular 应用中会有很多服务，一个组件又不可能会使用到所有服务，如果组件要使用到最后一个服务实例对象，难道要将前面的所有参数都写上吗 ? 这显然不合理。

在组件中获取服务实例对象要结合 TypeScript 类型，写法如下。

```javascript
import { AppService } from "./AppService"

export class AppComponent {
  constructor (
  	private appService: AppService
  ) {}
}
```

Angular 会根据你指定的服务的类型来传递你想要使用的服务实例对象，这样就解决了参数的顺序问题。

在 Angular 中服务被设计为单例模式，这也正是为什么服务可以被用来在组件之间共享数据和逻辑的原因。

### 3. 快速开始

#### 3.1 创建应用

1. 安装 angular-cli：`npm install @angular/cli -g`

2. 创建应用：`ng new angular-test --minimal --inlineTemplate false`

   1. --skipGit=true
   2. --minimal=true
   3. --skip-install
   4. --style=css
   5. --routing=false
   6. --inlineTemplate
   7. --inlineStyle
   8. --prefix


3. 运行应用：`ng serve`

   1. --open=true 应用构建完成后在浏览器中运行
   2. --hmr=true 开启热更新
   3. hmrWarning=false 禁用热更新警告
   4. --port 更改应用运行端口

4. 访问应用：`localhost:4200`


#### 3.2 默认代码解析

##### 3.2.1 main.ts

```javascript
// enableProdMode 方法调用后将会开启生产模式
import { enableProdMode } from "@angular/core"
// Angular 应用程序的启动在不同的平台上是不一样的
// 在浏览器中启动时需要用到 platformBrowserDynamic 方法, 该方法返回平台实例对象
import { platformBrowserDynamic } from "@angular/platform-browser-dynamic"
// 引入根模块 用于启动应用程序
import { AppModule } from "./app/app.module"
// 引入环境变量对象 { production: false }
import { environment } from "./environments/environment"

// 如果当前为生产环境
if (environment.production) {
  // 开启生产模式
  enableProdMode()
}
// 启动应用程序
platformBrowserDynamic()
  .bootstrapModule(AppModule)
  .catch(err => console.error(err))
```


##### 3.2.2 environment.ts

```javascript
// 在执行 `ng build --prod` 时, environment.prod.ts 文件会替换 environment.ts 文件
// 该项配置可以在 angular.json 文件中找到, projects -> angular-test -> architect -> configurations -> production -> fileReplacements

export const environment = {
  production: false
}
```

##### 3.2.3  environment.prod.ts

```javascript
export const environment = {
  production: true
}
```

##### 3.2.4 app.module.ts

```javascript
// BrowserModule 提供了启动和运行浏览器应用所必需的服务
// CommonModule 提供各种服务和指令, 例如 ngIf 和 ngFor, 与平台无关
// BrowserModule 导入了 CommonModule, 又重新导出了 CommonModule, 使其所有指令都可用于导入 BrowserModule 的任何模块 
import { BrowserModule } from "@angular/platform-browser"
// NgModule: Angular 模块装饰器
import { NgModule } from "@angular/core"
// 根组件
import { AppComponent } from "./app.component"
// 调用 NgModule 装饰器, 告诉 Angular 当前类表示的是 Angular 模块
@NgModule({
  // 声明当前模块拥有哪些组件
  declarations: [AppComponent],
  // 声明当前模块依赖了哪些其他模块
  imports: [BrowserModule],
  // 声明服务的作用域, 数组中接收服务类, 表示该服务只能在当前模块的组件中使用
  providers: [],
  // 可引导组件, Angular 会在引导过程中把它加载到 DOM 中
  bootstrap: [AppComponent]
})
export class AppModule {}
```

##### 3.2.5 app.component.ts

```javascript
import { Component } from "@angular/core"

@Component({
  // 指定组件的使用方式, 当前为标记形式
  // app-home   =>  <app-home></app-home>
	// [app-home] =>  <div app-home></div>
  // .app-home  =>  <div class="app-home"></div>
  selector: "app-root",
  // 关联组件模板文件
  // templateUrl:'组件模板文件路径'
	// template:`组件模板字符串`
  templateUrl: "./app.component.html",
  // 关联组件样式文件
  // styleUrls : ['组件样式文件路径']
	// styles : [`组件样式`]
  styleUrls: ["./app.component.css"]
})
export class AppComponent {}
```

##### 3.2.6 index.html

```html
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>AngularTest</title>
  <base href="/">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>
  <app-root></app-root>
</body>
</html>
```


#### 3.3 共享模块

共享模块当中放置的是 Angular 应用中模块级别的需要共享的组件或逻辑。

1. 创建共享模块： `ng g m shared` 

2. 创建共享组件：`ng g c shared/components/Layout`

3. 在共享模块中导出共享组件 

   ```javascript
   @NgModule({
     declarations: [LayoutComponent],
     exports: [LayoutComponent]
   })
   export class SharedModule {}
   ```

4. 在根模块中导入共享模块

   ```javascript
   @NgModule({
     declarations: [AppComponent],
     imports: [SharedModule],
     bootstrap: [AppComponent]
   })
   export class AppModule {}
   ```

5. 在根组件中使用 Layout 组件

   ```javascript
   @Component({
     selector: "app-root",
     template: `
       <div>App works</div>
       <app-layout></app-layout>
     `,
     styles: []
   })
   export class AppComponent { }
   ```

### 4. 组件模板

#### 4.1 数据绑定

数据绑定就是将组件类中的数据显示在组件模板中，当组件类中的数据发生变化时会自动被同步到组件模板中（数据驱动 DOM ）。

在 Angular 中使用差值表达式进行数据绑定，即 {{ }} 大胡子语法。

```html
<h2>{{message}}</h2>
<h2>{{getInfo()}}</h2>
<h2>{{a == b ? '相等': '不等'}}</h2>
<h2>{{'Hello Angular'}}</h2>
<p [innerHTML]="htmlSnippet"></p> <!-- 对数据中的代码进行转义 -->
```

#### 4.2 属性绑定

##### 4.2.1 普通属性

属性绑定分为两种情况，绑定 DOM 对象属性和绑定HTML标记属性。

1.  使用 [属性名称] 为元素绑定 DOM 对象属性。

```html
<img [src]="imgUrl"/>
```

2. 使用 [attr.属性名称] 为元素绑定 HTML 标记属性

```html
<td [attr.colspan]="colSpan"></td> 
```

在大多数情况下，DOM 对象属性和 HTML 标记属性是对应的关系，所以使用第一种情况。但是某些属性只有 HTML 标记存在，DOM 对象中不存在，此时需要使用第二种情况，比如 colspan 属性，在 DOM 对象中就没有，或者自定义 HTML 属性也需要使用第二种情况。

##### 4.2.2 class 属性

```html
<button class="btn btn-primary" [class.active]="isActive">按钮</button>
<div [ngClass]="{'active': true, 'error': true}"></div>
```

##### 4.2.3 style 属性

```html
<button [style.backgroundColor]="isActive ? 'blue': 'red'">按钮</button>
<button [ngStyle]="{'backgroundColor': 'red'}">按钮</button>
```

#### 4.3 事件绑定

```html
<button (click)="onSave($event)">按钮</button>
<!-- 当按下回车键抬起的时候执行函数 -->
<input type="text" (keyup.enter)="onKeyUp()"/>
```

```javascript
export class AppComponent {
  title = "test"
  onSave(event: Event) {
    // this 指向组件类的实例对象
    this.title // "test"
  }
}
```

#### 4.4 获取原生 DOM 对象

##### 4.4.1 在组件模板中获取

```html
<input type="text" (keyup.enter)="onKeyUp(username.value)" #username/>
```

##### 4.4.2 在组件类中获取

使用 ViewChild 装饰器获取一个元素

 ```html
<p #paragraph>home works!</p>
 ```

```javascript
import { AfterViewInit, ElementRef, ViewChild } from "@angular/core"

export class HomeComponent implements AfterViewInit {
  @ViewChild("paragraph") paragraph: ElementRef<HTMLParagraphElement> | undefined
  ngAfterViewInit() {
    console.log(this.paragraph?.nativeElement)
  }
}
```

使用 ViewChildren 获取一组元素

```html
<ul>
  <li #items>a</li>
  <li #items>b</li>
  <li #items>c</li>
</ul>
```

```javascript
import { AfterViewInit, QueryList, ViewChildren } from "@angular/core"

@Component({
  selector: "app-home",
  templateUrl: "./home.component.html",
  styles: []
})
export class HomeComponent implements AfterViewInit {
  @ViewChildren("items") items: QueryList<HTMLLIElement> | undefined
  ngAfterViewInit() {
    console.log(this.items?.toArray())
  }
}
```

#### 4.5 双向数据绑定

数据在组件类和组件模板中双向同步。

Angular 将双向数据绑定功能放在了 @angular/forms 模块中，所以要实现双向数据绑定需要依赖该模块。

```javascript
import { FormsModule } from "@angular/forms"

@NgModule({
  imports: [FormsModule],
})
export class AppModule {}
```

```html
<input type="text" [(ngModel)]="username" />
<button (click)="change()">在组件类中更改 username</button>
<div>username: {{ username }}</div>
```

```javascript
export class AppComponent {
  username: string = ""
  change() {
    this.username = "hello Angular"
  }
}
```

#### 4.6 内容投影

```html
<!-- app.component.html -->
<bootstrap-panel>
	<div class="heading">
        Heading
  </div>
  <div class="body">
        Body
  </div>
</bootstrap-panel>
```

```html
<!-- panel.component.html -->
<div class="panel panel-default">
  <div class="panel-heading">
    <ng-content select=".heading"></ng-content>
  </div>
  <div class="panel-body">
    <ng-content select=".body"></ng-content>
  </div>
</div>
```

如果只有一个ng-content，不需要select属性。

ng-content在浏览器中会被 \<div class="heading">\</div> 替代，如果不想要这个额外的div，可以使用ng-container替代这个div。

```html
<!-- app.component.html -->
<bootstrap-panel>
	<ng-container class="heading">
        Heading
    </ng-container>
    <ng-container class="body">
        Body
    </ng-container>
</bootstrap-panel>
```

#### 4.7  数据绑定容错处理

```javascript
// app.component.ts
export class AppComponent {
    task = {
        person: {
            name: '张三'
        }
    }
}
```

```html
<!-- 方式一 -->
<span *ngIf="task.person">{{ task.person.name }}</span>
<!-- 方式二 -->
<span>{{ task.person?.name }}</span>
```

#### 4.8 全局样式

```css
/* 第一种方式 在 styles.css 文件中 */
@import "~bootstrap/dist/css/bootstrap.css";
/* ~ 相对node_modules文件夹 */
```

```html
<!-- 第二种方式 在 index.html 文件中  -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
```

```javascript
// 第三种方式 在 angular.json 文件中
"styles": [
  "./node_modules/bootstrap/dist/css/bootstrap.min.css",
  "src/styles.css"
]
```

