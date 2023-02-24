### 1. 路由

#### 1.1 概述

在 Angular 中，路由是以模块为单位的，每个模块都可以有自己的路由。

#### 1.2 快速上手

1. 创建页面组件、Layout 组件以及 Navigation 组件，供路由使用

   1. 创建**首页**页面组件`ng g c pages/home`
   2.  创建**关于我们**页面组件`ng g c pages/about`
   3. 创建**布局**组件`ng g c pages/layout`
   4. 创建**导航**组件`ng g c pages/navigation`

2. 创建路由规则

   ```javascript
   // app.module.ts
   import { Routes } from "@angular/router"
   
   const routes: Routes = [
     {
       path: "home",
       component: HomeComponent
     },
     {
       path: "about",
       component: AboutComponent
     }
   ]
   ```

3. 引入路由模块并启动

   ```javascript
   // app.module.ts
   import { RouterModule, Routes } from "@angular/router"
   
   @NgModule({
     imports: [RouterModule.forRoot(routes, { useHash: true })],
   })
   export class AppModule {}
   ```

4. 添加路由插座

    ```html
   <!-- 路由插座即占位组件 匹配到的路由组件将会显示在这个地方 -->
   <router-outlet></router-outlet>
   ```

5. 在导航组件中定义链接

   ```html
   <a routerLink="/home">首页</a>
   <a routerLink="/about">关于我们</a>
   ```

#### 1.3 匹配规则

##### 1.3.1 重定向

```javascript
const routes: Routes = [
  {
    path: "home",
    component: HomeComponent
  },
  {
    path: "about",
    component: AboutComponent
  },
  {
    path: "",
    // 重定向
    redirectTo: "home",
    // 完全匹配
    pathMatch: "full"
  }
]
```

##### 1.3.2 404 页面

```javascript
const routes: Routes = [
  {
    path: "home",
    component: HomeComponent
  },
  {
    path: "about",
    component: AboutComponent
  },
  {
    path: "**",
    component: NotFoundComponent
  }
]
```

#### 1.4 路由传参

##### 1.4.1 查询参数

```html
<a routerLink="/about" [queryParams]="{ name: 'kitty' }">关于我们</a>
```

```javascript
import { ActivatedRoute } from "@angular/router"

export class AboutComponent implements OnInit {
  constructor(private route: ActivatedRoute) {}

  ngOnInit(): void {
    this.route.queryParamMap.subscribe(query => {
      query.get("name")
    })
  }
}
```

##### 1.4.2 动态参数

```javascript
const routes: Routes = [
  {
    path: "home",
    component: HomeComponent
  },
  {
    path: "about/:name",
    component: AboutComponent
  }
]
```

```html
<a [routerLink]="['/about', 'zhangsan']">关于我们</a>
```

```javascript
import { ActivatedRoute } from "@angular/router"

export class AboutComponent implements OnInit {
  constructor(private route: ActivatedRoute) {}

  ngOnInit(): void {
    this.route.paramMap.subscribe(params => {
      params.get("name")
    })
  }
}

```

#### 1.5 路由嵌套

路由嵌套指的是如何定义子级路由。

```javascript
const routes: Routes = [
  {
    path: "about",
    component: AboutComponent,
    children: [
      {
        path: "introduce",
        component: IntroduceComponent
      },
      {
        path: "history",
        component: HistoryComponent
      }
    ]
  }
]
```

```html
<!-- about.component.html -->
<app-layout>
  <p>about works!</p>
  <a routerLink="/about/introduce">公司简介</a>
  <a routerLink="/about/history">发展历史</a>
  <div>
    <router-outlet></router-outlet>
  </div>
</app-layout>
```

#### 1.6 命名插座

将子级路由组件显示到不同的路由插座中。

```javascript
{
  path: "about",
  component: AboutComponent,
  children: [
    {
      path: "introduce",
      component: IntroduceComponent,
      outlet: "left"
    },
    {
      path: "history",
      component: HistoryComponent,
      outlet: "right"
    }
  ]
}
```

```html
<!-- about.component.html -->
<app-layout>
  <p>about works!</p>
  <router-outlet name="left"></router-outlet>
  <router-outlet name="right"></router-outlet>
</app-layout>
```

```html
<a
    [routerLink]="[
      '/about',
      {
        outlets: {
          left: ['introduce'],
          right: ['history']
        }
      }
    ]"
    >关于我们
</a>
```

#### 1.7 导航路由

```html
<!-- app.component.html -->
 <button (click)="jump()">跳转到发展历史</button>
```

```javascript
// app.component.ts
import { Router } from "@angular/router"

export class HomeComponent {
  constructor(private router: Router) {}
  jump() {
    this.router.navigate(["/about/history"], {
      queryParams: {
        name: "Kitty"
      }
    })
  }
}
```

#### 1.8 路由模块

将根模块中的路由配置抽象成一个单独的路由模块，称之为根路由模块，然后在根模块中引入根路由模块。

```javascript
import { NgModule } from "@angular/core"

import { HomeComponent } from "./pages/home/home.component"
import { NotFoundComponent } from "./pages/not-found/not-found.component"

const routes: Routes = [
  {
    path: "",
    component: HomeComponent
  },
  {
    path: "**",
    component: NotFoundComponent
  }
]

@NgModule({
  declarations: [],
  imports: [RouterModule.forRoot(routes, { useHash: true })],
  // 导出 Angular 路由功能模块，因为在根模块的根组件中使用了 RouterModule 模块中提供的路由插座组件
  exports: [RouterModule]
})
export class AppRoutingModule {}
```

```javascript
import { BrowserModule } from "@angular/platform-browser"
import { NgModule } from "@angular/core"
import { AppComponent } from "./app.component"
import { AppRoutingModule } from "./app-routing.module"
import { HomeComponent } from "./pages/home/home.component"
import { NotFoundComponent } from "./pages/not-found/not-found.component"

@NgModule({
  declarations: [AppComponent，HomeComponent, NotFoundComponent],
  imports: [BrowserModule, AppRoutingModule],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule {}
```

#### 1.9 路由懒加载

路由懒加载是以模块为单位的。

1. 创建用户模块 `ng g m user --routing=true` 一并创建该模块的路由模块

2. 创建登录页面组件 `ng g c user/pages/login`

3. 创建注册页面组件 `ng g c user/pages/register`

4. 配置用户模块的路由规则

   ```javascript
   import { NgModule } from "@angular/core"
   import { Routes, RouterModule } from "@angular/router"
   import { LoginComponent } from "./pages/login/login.component"
   import { RegisterComponent } from "./pages/register/register.component"
   
   const routes: Routes = [
     {
       path: "login",
       component: LoginComponent
     },
     {
       path: "register",
       component: RegisterComponent
     }
   ]
   
   @NgModule({
     imports: [RouterModule.forChild(routes)],
     exports: [RouterModule]
   })
   export class UserRoutingModule {}
   ```

5. 将用户路由模块关联到主路由模块

   ```javascript
   // app-routing.module.ts
   const routes: Routes = [
     {
       path: "user",
       loadChildren: () => import("./user/user.module").then(m => m.UserModule)
     }
   ]
   ```

6. 在导航组件中添加访问链接

   ```html
   <a routerLink="/user/login">登录</a>
   <a routerLink="/user/register">注册</a>
   ```

#### 1.10 路由守卫

路由守卫会告诉路由是否允许导航到请求的路由。

路由守方法可以返回 boolean 或 Observable \<boolean\> 或 Promise \<boolean\>，它们在将来的某个时间点解析为布尔值。

##### 1.10.1 CanActivate

检查用户是否可以访问某一个路由。

CanActivate 为接口，路由守卫类要实现该接口，该接口规定类中需要有 canActivate 方法，方法决定是否允许访问目标路由。

路由可以应用多个守卫，所有守卫方法都允许，路由才被允许访问，有一个守卫方法不允许，则路由不允许被访问。

创建路由守卫：`ng g guard guards/auth`

```javascript
import { Injectable } from "@angular/core"
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree, Router } from "@angular/router"
import { Observable } from "rxjs"

@Injectable({
  providedIn: "root"
})
export class AuthGuard implements CanActivate {
  constructor(private router: Router) {}
  canActivate(): boolean | UrlTree {
    // 用于实现跳转
    return this.router.createUrlTree(["/user/login"])
    // 禁止访问目标路由
    return false
    // 允许访问目标路由
    return true
  }
}

```

```javascript
{
  path: "about",
  component: AboutComponent,
  canActivate: [AuthGuard]
}
```

##### 1.10.2 CanActivateChild

检查用户是否方可访问某个子路由。

创建路由守卫：`ng g guard guards/admin` 注意：选择 CanActivateChild，需要将箭头移动到这个选项并且敲击空格确认选择。

```javascript
import { Injectable } from "@angular/core"
import { CanActivateChild, ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree } from "@angular/router"
import { Observable } from "rxjs"

@Injectable({
  providedIn: "root"
})
export class AdminGuard implements CanActivateChild {
  canActivateChild(): boolean | UrlTree {
    return true
  }
}
```

```javascript
{
  path: "about",
  component: AboutComponent,
  canActivateChild: [AdminGuard],
  children: [
    {
      path: "introduce",
      component: IntroduceComponent
    }
  ]
}
```

##### 1.10.3 CanDeactivate

检查用户是否可以退出路由。比如用户在表单中输入的内容没有保存，用户又要离开路由，此时可以调用该守卫提示用户。

```javascript
import { Injectable } from "@angular/core"
import {
  CanDeactivate,
  ActivatedRouteSnapshot,
  RouterStateSnapshot,
  UrlTree
} from "@angular/router"
import { Observable } from "rxjs"

export interface CanComponentLeave {
  canLeave: () => boolean
}

@Injectable({
  providedIn: "root"
})
export class UnsaveGuard implements CanDeactivate<CanComponentLeave> {
  canDeactivate(component: CanComponentLeave): boolean {
    if (component.canLeave()) {
      return true
    }
    return false
  }
}
```

```javascript
{
  path: "",
  component: HomeComponent,
  canDeactivate: [UnsaveGuard]
}
```

```javascript
import { CanComponentLeave } from "src/app/guards/unsave.guard"

export class HomeComponent implements CanComponentLeave {
  myForm: FormGroup = new FormGroup({
    username: new FormControl()
  })
  canLeave(): boolean {
    if (this.myForm.dirty) {
      if (window.confirm("有数据未保存, 确定要离开吗")) {
        return true
      } else {
        return false
      }
    }
    return true
  }

```

##### 1.10.4 Resolve

允许在进入路由之前先获取数据，待数据获取完成之后再进入路由。

`ng g resolver <name>`

```javascript
import { Injectable } from "@angular/core"
import { Resolve } from "@angular/router"

type returnType = Promise<{ name: string }>

@Injectable({
  providedIn: "root"
})
export class ResolveGuard implements Resolve<returnType> {
  resolve(): returnType {
    return new Promise(function (resolve) {
      setTimeout(() => {
        resolve({ name: "张三" })
      }, 2000)
    })
  }
}
```

```javascript
{
   path: "",
   component: HomeComponent,
   resolve: {
     user: ResolveGuard
   }
}
```

```javascript
export class HomeComponent {
  constructor(private route: ActivatedRoute) {}
  ngOnInit(): void {
    console.log(this.route.snapshot.data.user)
  }
}
```