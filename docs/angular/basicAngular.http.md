### 1. HttpClientModule

该模块用于发送 Http 请求，用于发送请求的方法都返回 Observable 对象。

#### 1.1 快速开始

1. 引入 HttpClientModule 模块

   ```javascript
   // app.module.ts
   import { httpClientModule } from '@angular/common/http';
   imports: [
     httpClientModule
   ]
   ```

2. 注入 HttpClient 服务实例对象，用于发送请求

   ```javascript
   // app.component.ts
   import { HttpClient } from '@angular/common/http';
   
   export class AppComponent {
   	constructor(private http: HttpClient) {}
   }
   ```

3. 发送请求

   ```javascript
   import { HttpClient } from "@angular/common/http"
   
   export class AppComponent implements OnInit {
     constructor(private http: HttpClient) {}
     ngOnInit() {
       this.getUsers().subscribe(console.log)
     }
     getUsers() {
       return this.http.get("https://jsonplaceholder.typicode.com/users")
     }
   }
   ```

#### 1.2  请求方法

```javascript
this.http.get(url [, options]);
this.http.post(url, data [, options]);
this.http.delete(url [, options]);
this.http.put(url, data [, options]);
```

```javascript
this.http.get<Post[]>('/getAllPosts')
  .subscribe(response => console.log(response))
```

#### 1.3 请求参数

1. HttpParams 类

   ```javascript
   export declare class HttpParams {
       constructor(options?: HttpParamsOptions);
       has(param: string): boolean;
       get(param: string): string | null;
       getAll(param: string): string[] | null;
       keys(): string[];
       append(param: string, value: string): HttpParams;
       set(param: string, value: string): HttpParams;
       delete(param: string, value?: string): HttpParams;
       toString(): string;
   }
   ```

2. HttpParamsOptions 接口

   ```javascript
   declare interface HttpParamsOptions {
       fromString?: string;
       fromObject?: {
           [param: string]: string | ReadonlyArray<string>;
       };
       encoder?: HttpParameterCodec;
   }
   ```

3. 使用示例

   ```javascript
   import { HttpParams } from '@angular/common/http';
   
   let params = new HttpParams({ fromObject: {name: "zhangsan", age: "20"}})
   params = params.append("sex", "male")
   let params = new HttpParams({ fromString: "name=zhangsan&age=20"})
   ```


#### 1.4 请求头

请求头字段的创建需要使用 HttpHeaders 类，在类实例对象下面有各种操作请求头的方法。

```javascript
export declare class HttpHeaders {
    constructor(headers?: string | {
        [name: string]: string | string[];
    });
    has(name: string): boolean;
    get(name: string): string | null;
    keys(): string[];
    getAll(name: string): string[] | null;
    append(name: string, value: string | string[]): HttpHeaders;
    set(name: string, value: string | string[]): HttpHeaders;
    delete(name: string, value?: string | string[]): HttpHeaders;
}
```

```javascript
let headers = new HttpHeaders({ test: "Hello" })
```

#### 1.5 响应内容

```javascript
declare type HttpObserve = 'body' | 'response';
// response 读取完整响应体
// body 读取服务器端返回的数据
```

```javascript
this.http.get(
  "https://jsonplaceholder.typicode.com/users", 
  { observe: "body" }
).subscribe(console.log)
```

#### 1.6 拦截器

拦截器是 Angular 应用中全局捕获和修改 HTTP 请求和响应的方式。（Token、Error）

拦截器将只拦截使用 HttpClientModule 模块发出的请求。

`ng g interceptor <name>`

##### 1.6.1 请求拦截

```javascript
@Injectable()
export class AuthInterceptor implements HttpInterceptor {
  constructor() {}
	// 拦截方法
  intercept(
  	// unknown 指定请求体 (body) 的类型
    request: HttpRequest<unknown>,
    next: HttpHandler
     // unknown 指定响应内容 (body) 的类型
  ): Observable<HttpEvent<unknown>> {
    // 克隆并修改请求头
    const req = request.clone({
      setHeaders: {
        Authorization: "Bearer xxxxxxx"
      }
    })
    // 通过回调函数将修改后的请求头回传给应用
    return next.handle(req)
  }
}
```

##### 1.6.2 响应拦截

```javascript
@Injectable()
export class AuthInterceptor implements HttpInterceptor {
  constructor() {}
	// 拦截方法
  intercept(
    request: HttpRequest<unknown>,
    next: HttpHandler
  ): Observable<any> {
    return next.handle(request).pipe(
      retry(2),
      catchError((error: HttpErrorResponse) => throwError(error))
    )
  }
}
```

##### 1.5.3 拦截器注入

```javascript
import { AuthInterceptor } from "./auth.interceptor"
import { HTTP_INTERCEPTORS } from "@angular/common/http"

@NgModule({
  providers: [
    {
      provide: HTTP_INTERCEPTORS,
      useClass: AuthInterceptor,
      multi: true
    }
  ]
})
```

#### 1.7 Angular Proxy

1. 在项目的根目录下创建  proxy.conf.json 文件并加入如下代码

   ```json
   {
    	"/api/*": {
       "target": "http://localhost:3070",
       "secure": false,
       "changeOrigin": true
     }
   }
   ```

   1. /api/*：在应用中发出的以 /api 开头的请求走此代理
   2. target：服务器端 URL
   3. secure：如果服务器端 URL 的协议是 https，此项需要为 true
   4. changeOrigin：如果服务器端不是 localhost， 此项需要为 true

2. 指定 proxy 配置文件 (方式一) 

   ```javascript
   "scripts": {
     "start": "ng serve --proxy-config proxy.conf.json",
   }
   ```

3. 指定 proxy 配置文件 (方式二)

   ```json
   "serve": {
     "options": {
       "proxyConfig": "proxy.conf.json"
     },
   ```
