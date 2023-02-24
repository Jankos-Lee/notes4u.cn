### 15. NgRx

#### 15.1 概述

NgRx 是 Angular 应用中实现全局状态管理的 Redux 架构解决方案。

1. @ngrx/store：全局状态管理模块
2. @ngrx/effects：处理副作用
3. @ngrx/store-devtools：浏览器调试工具，需要依赖 [Redux Devtools Extension](https://github.com/zalmoxisus/redux-devtools-extension/)
4. @ngrx/schematics：命令行工具，快速生成 NgRx 文件
5. @ngrx/entity：提高开发者在 Reducer 中操作数据的效率
6. @ngrx/router-store：将路由状态同步到全局 Store

#### 15.2 快速开始

1. 下载 NgRx

   `npm install @ngrx/store @ngrx/effects @ngrx/entity @ngrx/router-store @ngrx/store-devtools @ngrx/schematics`

2. 配置 NgRx CLI

   `ng config cli.defaultCollection @ngrx/schematics`

   ```javascript
   // angular.json
   "cli": {
     "defaultCollection": "@ngrx/schematics"
   }
   ```

3. 创建 Store

   `ng g store State --root --module app.module.ts --statePath store --stateInterface AppState`

4. 创建 Action

   `ng g action store/actions/counter --skipTests`

   ```javascript
   import { createAction } from "@ngrx/store"
   
   export const increment = createAction("increment")
   export const decrement = createAction("decrement")
   ```

5. 创建 Reducer

   `ng g reducer store/reducers/counter --skipTests --reducers=../index.ts`

   ```javascript
   import { createReducer, on } from "@ngrx/store"
   import { decrement, increment } from "../actions/counter.actions"
   
   export const counterFeatureKey = "counter"
   
   export interface State {
     count: number
   }
   
   export const initialState: State = {
     count: 0
   }
   
   export const reducer = createReducer(
     initialState,
     on(increment, state => ({ count: state.count + 1 })),
     on(decrement, state => ({ count: state.count - 1 }))
   )
   ```

6. 创建 Selector

   `ng g selector store/selectors/counter --skipTests`

   ```javascript
   import { createFeatureSelector, createSelector } from "@ngrx/store"
   import { counterFeatureKey, State } from "../reducers/counter.reducer"
   import { AppState } from ".."
   
   export const selectCounter = createFeatureSelector<AppState, State>(counterFeatureKey)
   export const selectCount = createSelector(selectCounter, state => state.count)
   ```

7. 组件类触发 Action、获取状态

   ```javascript
   import { select, Store } from "@ngrx/store"
   import { Observable } from "rxjs"
   import { AppState } from "./store"
   import { decrement, increment } from "./store/actions/counter.actions"
   import { selectCount } from "./store/selectors/counter.selectors"
   
   export class AppComponent {
     count: Observable<number>
     constructor(private store: Store<AppState>) {
       this.count = this.store.pipe(select(selectCount))
     }
     increment() {
       this.store.dispatch(increment())
     }
     decrement() {
       this.store.dispatch(decrement())
     }
   }
   ```

8. 组件模板显示状态

   ```html
   <button (click)="increment()">+</button>
   <span>{{ count | async }}</span>
   <button (click)="decrement()">-</button>
   ```

#### 15.3 Action Payload

1. 在组件中使用 dispatch 触发 Action 时传递参数，参数最终会被放置在 Action 对象中。

   ```javascript
   this.store.dispatch(increment({ count: 5 }))
   ```

2. 在创建 Action Creator 函数时，获取参数并指定参数类型。

   ```javascript
   import { createAction, props } from "@ngrx/store"
   export const increment = createAction("increment", props<{ count: number }>())
   ```

   ```javascript
   export declare function props<P extends object>(): Props<P>;
   ```

3. 在 Reducer 中通过 Action 对象获取参数。

   ```javascript
   export const reducer = createReducer(
     initialState,
     on(increment, (state, action) => ({ count: state.count + action.count }))
   )
   ```

#### 15.4 MetaReducer

metaReducer 是 Action -> Reducer 之间的钩子，允许开发者对 Action 进行预处理 (在普通 Reducer 函数调用之前调用)。

```javascript
function debug(reducer: ActionReducer<any>): ActionReducer<any> {
  return function (state, action) {
    return reducer(state, action)
  }
}

export const metaReducers: MetaReducer<AppState>[] = !environment.production
  ? [debug]
  : []
```

#### 15.5 Effect

需求：在页面中新增一个按钮，点击按钮后延迟一秒让数值增加。

1. 在组件模板中新增一个用于异步数值增加的按钮，按钮被点击后执行 `increment_async` 方法

   ```html
   <button (click)="increment_async()">async</button>
   ```

2. 在组件类中新增 `increment_async` 方法，并在方法中触发执行异步操作的 Action

   ```javascript
   increment_async() {
     this.store.dispatch(increment_async())
   }
   ```

3. 在 Action 文件中新增执行异步操作的 Action

   ```javascript
   export const increment_async = createAction("increment_async")
   ```

4. 创建 Effect，接收 Action 并执行副作用，继续触发 Action

   `ng g effect store/effects/counter --root --module app.module.ts --skipTests`

   Effect 功能由 @ngrx/effects 模块提供，所以在根模块中需要导入相关的模块依赖

   ```javascript
   import { Injectable } from "@angular/core"
   import { Actions, createEffect, ofType } from "@ngrx/effects"
   import { increment, increment_async } from "../actions/counter.actions"
   import { mergeMap, map } from "rxjs/operators"
   import { timer } from "rxjs"
   
   // createEffect
   // 用于创建 Effect, Effect 用于执行副作用.
   // 调用方法时传递回调函数, 回调函数中返回 Observable 对象, 对象中要发出副作用执行完成后要触发的 Action 对象
   // 回调函数的返回值在 createEffect 方法内部被继续返回, 最终返回值被存储在了 Effect 类的属性中
   // NgRx 在实例化 Effect 类后, 会订阅 Effect 类属性, 当副作用执行完成后它会获取到要触发的 Action 对象并触发这个 Action
   
   // Actions
   // 当组件触发 Action 时, Effect 需要通过 Actions 服务接收 Action, 所以在 Effect 类中通过 constructor 构造函数参数的方式将 Actions 服务类的实例对象注入到 Effect 类中
   // Actions 服务类的实例对象为 Observable 对象, 当有 Action 被触发时, Action 对象本身会作为数据流被发出
   
   // ofType
   // 对目标 Action 对象进行过滤.
   // 参数为目标 Action 的 Action Creator 函数
   // 如果未过滤出目标 Action 对象, 本次不会继续发送数据流
   // 如果过滤出目标 Action 对象, 会将 Action 对象作为数据流继续发出
   
   @Injectable()
   export class CounterEffects {
     constructor(private actions: Actions) {
       // this.loadCount.subscribe(console.log)
     }
     loadCount = createEffect(() => {
       return this.actions.pipe(
         ofType(increment_async),
         mergeMap(() => timer(1000).pipe(map(() => increment({ count: 10 }))))
       )
     })
   }
   ```

#### 15.6 Entity

##### 15.6.1 概述

Entity 译为实体，实体就是集合中的一条数据。

NgRx 中提供了实体适配器对象，在实体适配器对象下面提供了各种操作集合中实体的方法，目的就是提高开发者操作实体的效率。

##### 15.6.2 核心

1. EntityState：实体类型接口

   ```javascript
   /*
   	{
   		ids: [1, 2],
   		entities: {
   			1: { id: 1, title: "Hello Angular" },
   			2: { id: 2, title: "Hello NgRx" }
   		}
   	}
   */
   export interface State extends EntityState<Todo> {}
   ```

2. createEntityAdapter： 创建实体适配器对象

3. EntityAdapter：实体适配器对象类型接口

   ```javascript
   export const adapter: EntityAdapter<Todo> = createEntityAdapter<Todo>()
   // 获取初始状态 可以传递对象参数 也可以不传
   // {ids: [], entities: {}}
   export const initialState: State = adapter.getInitialState()
   ```

##### 15.6.3 实例方法

https://ngrx.io/guide/entity/adapter#adapter-collection-methods

##### 15.6.4 选择器

```javascript
// selectTotal 获取数据条数
// selectAll 获取所有数据 以数组形式呈现
// selectEntities 获取实体集合 以字典形式呈现
// selectIds 获取id集合, 以数组形式呈现
const { selectIds, selectEntities, selectAll, selectTotal } = adapter.getSelectors();
```

```javascript
export const selectTodo = createFeatureSelector<AppState, State>(todoFeatureKey)
export const selectTodos = createSelector(selectTodo, selectAll)
```

#### 15.7 Router Store

##### 15.7.1 同步路由状态

1. 引入模块

   ```javascript
   import { StoreRouterConnectingModule } from "@ngrx/router-store"
   
   @NgModule({
     imports: [
       StoreRouterConnectingModule.forRoot()
     ]
   })
   export class AppModule {}
   ```

2. 将路由状态集成到 Store

   ```javascript
   import * as fromRouter from "@ngrx/router-store"
   
   export interface AppState {
     router: fromRouter.RouterReducerState
   }
   export const reducers: ActionReducerMap<AppState> = {
     router: fromRouter.routerReducer
   }
   ```

##### 15.7.2 创建获取路由状态的 Selector

```javascript
// router.selectors.ts
import { createFeatureSelector } from "@ngrx/store"
import { AppState } from ".."
import { RouterReducerState, getSelectors } from "@ngrx/router-store"

const selectRouter = createFeatureSelector<AppState, RouterReducerState>(
  "router"
)

export const {
  // 获取和当前路由相关的信息 (路由参数、路由配置等)
  selectCurrentRoute,
  // 获取地址栏中 # 号后面的内容
  selectFragment,
  // 获取路由查询参数
  selectQueryParams,
  // 获取具体的某一个查询参数 selectQueryParam('name')
  selectQueryParam,
  // 获取动态路由参数
  selectRouteParams,
 	// 获取某一个具体的动态路由参数 selectRouteParam('name')
  selectRouteParam,
  // 获取路由自定义数据
  selectRouteData,
  // 获取路由的实际访问地址
  selectUrl
} = getSelectors(selectRouter)
```

```javascript
// home.component.ts
import { select, Store } from "@ngrx/store"
import { AppState } from "src/app/store"
import { selectQueryParams } from "src/app/store/selectors/router.selectors"

export class AboutComponent {
  constructor(private store: Store<AppState>) {
    this.store.pipe(select(selectQueryParams)).subscribe(console.log)
  }
}
```