### 1. 指令 Directive

指令是 Angular 提供的操作 DOM 的途径。指令分为属性指令和结构指令。

属性指令：修改现有元素的外观或行为，使用 [] 包裹。

结构指令：增加、删除 DOM 节点以修改布局，使用*作为指令前缀

#### 1.1 内置指令

##### 1.1.1 *ngIf 

根据条件渲染 DOM 节点或移除 DOM 节点。

```html
<div *ngIf="data.length == 0">没有更多数据</div>
```

```html
<div *ngIf="data.length > 0; then dataList else noData"></div>
<ng-template #dataList>课程列表</ng-template>
<ng-template #noData>没有更多数据</ng-template>
```

##### 1.1.2 [hidden]

根据条件显示 DOM 节点或隐藏 DOM 节点 (display)。 

```html
<div [hidden]="data.length == 0">课程列表</div>
<div [hidden]="data.length > 0">没有更多数据</div>
```

##### 1.1.3 *ngFor

遍历数据生成HTML结构

```javascript
interface List {
  id: number
  name: string
  age: number
}

list: List[] = [
  { id: 1, name: "张三", age: 20 },
  { id: 2, name: "李四", age: 30 }
]
```

```html
<li
    *ngFor="
      let item of list;
      let i = index;
      let isEven = even;
      let isOdd = odd;
      let isFirst = first;
      let isLast = last;
    "
  >
  </li>
```

```html
<li *ngFor="let item of list; trackBy: identify"></li>
```

```javascript
identify(index, item){
  return item.id; 
}
```

#### 1.2 自定义指令

需求：为元素设置默认背景颜色，鼠标移入时的背景颜色以及移出时的背景颜色。

 ```html
<div [appHover]="{ bgColor: 'skyblue' }">Hello Angular</div>
 ```

```javascript
import { AfterViewInit, Directive, ElementRef, HostListener, Input } from "@angular/core"

// 接收参的数类型
interface Options {
  bgColor?: string
}

@Directive({
  selector: "[appHover]"
})
export class HoverDirective implements AfterViewInit {
  // 接收参数
  @Input("appHover") appHover: Options = {}
  // 要操作的 DOM 节点
  element: HTMLElement
	// 获取要操作的 DOM 节点
  constructor(private elementRef: ElementRef) {
    this.element = this.elementRef.nativeElement
  }
	// 组件模板初始完成后设置元素的背景颜色
  ngAfterViewInit() {
    this.element.style.backgroundColor = this.appHover.bgColor || "skyblue"
  }
	// 为元素添加鼠标移入事件
  @HostListener("mouseenter") enter() {
    this.element.style.backgroundColor = "pink"
  }
	// 为元素添加鼠标移出事件
  @HostListener("mouseleave") leave() {
    this.element.style.backgroundColor = "skyblue"
  }
}

```

### 2. 管道 Pipe

管道的作用是格式化组件模板数据。

#### 2.1 内置管道

1. date 日期格式化
3. currency 货币格式化
4. uppercase 转大写
1. lowercase 转小写
1. json 格式化json 数据

```html
{{ date | date: "yyyy-MM-dd" }}
```

#### 2.2 自定义管道

需求：指定字符串不能超过规定的长度

```javascript
// summary.pipe.ts
import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
   name: 'summary' 
});
export class SummaryPipe implements PipeTransform {
    transform (value: string, limit?: number) {
        if (!value) return null;
        let actualLimit = (limit) ? limit : 50;
        return value.substr(0, actualLimit) + '...';
    }
}
```

```typescript
// app.module.ts
import { SummaryPipe } from './summary.pipe'
@NgModule({
    declarations: [
      SummaryPipe
    ] 
});
```

### 3. 组件通讯

#### 3.1 向组件内部传递数据

```html
<app-favorite [isFavorite]="true"></app-favorite>
```

```javascript
// favorite.component.ts
import { Input } from '@angular/core';
export class FavoriteComponent {
    @Input() isFavorite: boolean = false;
}
```

注意：在属性的外面加 [] 表示绑定动态值，在组件内接收后是布尔类型，不加 [] 表示绑定普通值，在组件内接收后是字符串类型。

```html
<app-favorite [is-Favorite]="true"></app-favorite>
```

```javascript
import { Input } from '@angular/core';

export class FavoriteComponent {
  @Input("is-Favorite") isFavorite: boolean = false
}
```

#### 3.2 组件向外部传递数据

需求：在子组件中通过点击按钮将数据传递给父组件

```html
<!-- 子组件模板 -->
<button (click)="onClick()">click</button>
```

```javascript
// 子组件类
import { EventEmitter, Output } from "@angular/core"

export class FavoriteComponent {
  @Output() change = new EventEmitter()
  onClick() {
    this.change.emit({ name: "张三" })
  }
}
```

```html
<!-- 父组件模板 -->
<app-favorite (change)="onChange($event)"></app-favorite>
```

```javascript
// 父组件类
export class AppComponent {
  onChange(event: { name: string }) {
    console.log(event)
  }
}
```
### 4. 组件生命周期


#### 4.1 挂载阶段

挂载阶段的生命周期函数只在挂载阶段执行一次，数据更新时不再执行。

1. constructor

   Angular 在实例化组件类时执行,  可以用来接收 Angular 注入的服务实例对象。

   ```javascript
   export class ChildComponent {
     constructor (private test: TestService) {
       console.log(this.test) // "test"
     }
   }
   ```

2. ngOnInit

   在首次接收到输入属性值后执行，在此处可以执行请求操作。

   ```html
   <app-child name="张三"></app-child>
   ```

   ```javascript
   export class ChildComponent implements OnInit {
     @Input("name") name: string = ""
     ngOnInit() {
       console.log(this.name) // "张三"
     }
   }
   ```

3. ngAfterContentInit

   当内容投影初始渲染完成后调用。

   ```html
   <app-child>
   	<div #box>Hello Angular</div>
   </app-child>
   ```

   ```javascript
   export class ChildComponent implements AfterContentInit {
     @ContentChild("box") box: ElementRef<HTMLDivElement> | undefined
   
     ngAfterContentInit() {
       console.log(this.box) // <div>Hello Angular</div>
     }
   }
   ```

4. ngAfterViewInit

   当组件视图渲染完成后调用。

   ```html
   <!-- app-child 组件模板 -->
   <p #p>app-child works</p>
   ```

   ```javascript
   export class ChildComponent implements AfterViewInit {
     @ViewChild("p") p: ElementRef<HTMLParagraphElement> | undefined
     ngAfterViewInit () {
       console.log(this.p) // <p>app-child works</p>
     }
   }
   ```

#### 4.2 更新阶段

1. ngOnChanges

   1. 当输入属性值发生变化时执行，初始设置时也会执行一次，顺序优于 ngOnInit
   2. 不论多少输入属性同时变化，钩子函数只会执行一次，变化的值会同时存储在参数中
   3. 参数类型为 SimpleChanges，子属性类型为 SimpleChange
   4. 对于基本数据类型来说, 只要值发生变化就可以被检测到
   1. 对于引用数据类型来说, 可以检测从一个对象变成另一个对象, 但是检测不到同一个对象中属性值的变化，但是不影响组件模板更新数据。

   **基本数据类型值变化**

   ```html
   <app-child [name]="name" [age]="age"></app-child>
   <button (click)="change()">change</button>
   ```

   ```javascript
   export class AppComponent {
     name: string = "张三";
   	age: number = 20
     change() {
       this.name = "李四"
       this.age = 30
     }
   }
   ```

   ```javascript
   export class ChildComponent implements OnChanges {
     @Input("name") name: string = ""
   	@Input("age") age: number = 0
   
     ngOnChanges(changes: SimpleChanges) {
       console.log("基本数据类型值变化可以被检测到")
     }
   }
   ```

   **引用数据类型变化**

   ```html
   <app-child [person]="person"></app-child>
   <button (click)="change()">change</button>
   ```

   ```javascript
   export class AppComponent {
     person = { name: "张三", age: 20 }
     change() {
       this.person = { name: "李四", age: 30 }
     }
   }
   ```

   ```javascript
   export class ChildComponent implements OnChanges {
     @Input("person") person = { name: "", age: 0 }
   
     ngOnChanges(changes: SimpleChanges) {
       console.log("对于引用数据类型, 只能检测到引用地址发生变化, 对象属性变化不能被检测到")
     }
   }
   ```

2. ngDoCheck：主要用于调试，只要输入属性发生变化，不论是基本数据类型还是引用数据类型还是引用数据类型中的属性变化，都会执行。

3. ngAfterContentChecked：内容投影更新完成后执行。

4. ngAfterViewChecked：组件视图更新完成后执行。

#### 4.3 卸载阶段

1. ngOnDestroy

   当组件被销毁之前调用, 用于清理操作。

   ```javascript
   export class HomeComponent implements OnDestroy {
     ngOnDestroy() {
       console.log("组件被卸载")
     }
   }
   ```

### 5. 依赖注入

#### 5.1 概述

依赖注入 ( Dependency Injection ) 简称DI，是面向对象编程中的一种设计原则，用来减少代码之间的**耦合度**。

```javascript
class MailService {
  constructor(APIKEY) {}
}

class EmailSender {
  mailService: MailService
  constructor() {
    this.mailService = new MailService("APIKEY1234567890")
  }

  sendMail(mail) {
    this.mailService.sendMail(mail)
  }
}

const emailSender = new EmailSender()
emailSender.sendMail(mail)
```

EmailSender 类运行时要使用 MailService 类，EmailSender 类依赖 MailService 类，MailService 类是 EmailSender 类的依赖项。

以上写法的耦合度太高，代码并不健壮。如果 MailService 类改变了参数的传递方式，在 EmailSender 类中的写法也要跟着改变。

```javascript
class EmailSender {
  mailService: MailService
  constructor(mailService: MailService) {
    this.mailService = mailService;
  }
}
const mailService = new MailService("APIKEY1234567890")
const emailSender = new EmailSender(mailService)
```

在实例化 EmailSender 类时将它的依赖项通过 constructor 构造函数参数的形式注入到类的内部，这种写法就是依赖注入。

通过依赖注入降了代码之间的耦合度，增加了代码的可维护性。MailService 类中代码的更改再也不会影响 EmailSender 类。

#### 5.2 DI 框架

Angular 有自己的 DI 框架，它将实现依赖注入的过程隐藏了，对于开发者来说只需使用很简单的代码就可以使用复杂的依赖注入功能。

在 Angular 的 DI 框架中有四个核心概念：

1. Dependency：组件要依赖的实例对象，服务实例对象
2. Token：获取服务实例对象的标识
3. Injector：注入器，负责创建维护服务类的实例对象并向组件中注入服务实例对象。
4. Provider：配置注入器的对象，指定创建服务实例对象的服务类和获取实例对象的标识。

##### 5.2.1 注入器 Injectors

注入器负责创建服务类实例对象，并将服务类实例对象注入到需要的组件中。

1. 创建注入器

   ```javascript
   import { ReflectiveInjector } from "@angular/core"
   // 服务类
   class MailService {}
   // 创建注入器并传入服务类
   const injector = ReflectiveInjector.resolveAndCreate([MailService])
   ```

2. 获取注入器中的服务类实例对象

   ```javascript
   const mailService = injector.get(MailService)
   ```

3. 服务实例对象为单例模式，注入器在创建服务实例后会对其进行缓存

   ```javascript
   const mailService1 = injector.get(MailService)
   const mailService2 = injector.get(MailService)
   
   console.log(mailService1 === mailService2) // true
   ```

4. 不同的注入器返回不同的服务实例对象

   ```javascript
   const injector = ReflectiveInjector.resolveAndCreate([MailService])
   const childInjector = injector.resolveAndCreateChild([MailService])
   
   const mailService1 = injector.get(MailService)
   const mailService2 = childInjector.get(MailService)
   
   console.log(mailService1 === mailService2)
   ```

1. 服务实例的查找类似函数作用域链，当前级别可以找到就使用当前级别，当前级别找不到去父级中查找

   ```javascript
   const injector = ReflectiveInjector.resolveAndCreate([MailService])
   const childInjector = injector.resolveAndCreateChild([])
   
   const mailService1 = injector.get(MailService)
   const mailService2 = childInjector.get(MailService)
   
   console.log(mailService1 === mailService2)
   ```


##### 5.2.2 提供者 Provider

1. 配置注入器的对象，指定了创建实例对象的服务类和访问服务实例对象的标识。

   ```javascript
   const injector = ReflectiveInjector.resolveAndCreate([
     { provide: MailService, useClass: MailService }
   ])
   ```

2. 访问依赖对象的标识也可以是字符串类型

   ```javascript
   const injector = ReflectiveInjector.resolveAndCreate([
     { provide: "mail", useClass: MailService }
   ])
   const mailService = injector.get("mail")
   ```

3. useValue

   ```javascript
   const injector = ReflectiveInjector.resolveAndCreate([
     {
       provide: "Config",
       useValue: Object.freeze({
         APIKEY: "API1234567890",
         APISCRET: "500-400-300"
       })
     }
   ])
   const Config = injector.get("Config")
   ```

将实例对象和外部的引用建立了松耦合关系，外部通过标识获取实例对象，只要标识保持不变，内部代码怎么变都不会影响到外部。

### 6. 服务 Service

#### 6.1 创建服务

```javascript
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class TestService { }
```

```javascript
export class AppComponent {
 	constructor (private testService: TestService) {}
}
```

#### 6.2 服务的作用域

使用服务可以轻松实现跨模块跨组件共享数据，这取决于服务的作用域。

1. 在根注入器中注册服务，所有模块使用同一个服务实例对象。

   ```javascript
   import { Injectable } from '@angular/core';
   
   @Injectable({
     providedIn: 'root'
   })
   
   export class CarListService {
   }
   ```

2. 在模块级别注册服务，该模块中的所有组件使用同一个服务实例对象。

   ```javascript
   import { Injectable } from '@angular/core';
   import { CarModule } from './car.module';
   
   @Injectable({
     providedIn: CarModule,
   })
   
   export class CarListService {
   }
   ```

   ```javascript
   import { CarListService } from './car-list.service';
   
   @NgModule({
     providers: [CarListService],
   })
   export class CarModule {
   }
   ```

3. 在组件级别注册服务，该组件及其子组件使用同一个服务实例对象。

   ```javascript
   import { Component } from '@angular/core';
   import { CarListService } from '../car-list.service.ts'
   
   @Component({
     selector:    'app-car-list',
     templateUrl: './car-list.component.html',
     providers:  [ CarListService ]
   })
   ```