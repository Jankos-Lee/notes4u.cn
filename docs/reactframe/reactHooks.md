#### 1.useState

> 让函数式组件保存状态，设置状态值方法本身是异步的

```
1.接受唯一的参数，即状态的初始值可以是任务数据类型；
2.返回值为一个数组,分别为状态的值和设置状态的方法，约定设置状态值的方法以set 状态名 命名；
3.方法可以被多次调用，以保存不同状态的值；
4.参数可以是一个函数，函数返回什么初始状态就是什么；函数只会被调用一次用在初始值是动态值的情况；
```

#### 2.useReducer

> 让函数型组件保存状态

```
eg:
function reducer(state, action) {
	switch (action.type) {
		case 'increment':
			return state + 1;
		case 'decrement':
			return state - 1;
	}
}
const [count, dispath] = useReducer(reducer, 0);

<button onClick={dispath({type: 'increment'})} />
<button onClick={dispath({type: 'decrement'})} />

```

#### 3.useContext

> 在跨组件层级获取数据时简化获取数据时的代码

```
import React, { createContext, useContext } from 'react';
const countContext = createContext();
function App() {
 return <countContext.Provider value={200}>
 	<Foo />
 	</countContext.Provider>
}

function Foo() {
	return <countContext.Consumer>
	{
		value => <div>{value}</div>
	}
	</countContext.Consumer>
}
function Foo() {
	const valueuseContext(countCOntext)
	return <div>{value}</div>
}
export default App;
```

#### 4.useEffect

> 让函数式组件拥有处理副作用的能力，类似生命周期函数
>
> useEffect中的参数函数不能是异步函数，因为useEffect函数要返回清理资源的函数，如果是异步函数就变成了返回 Promise 

```
1.useEffect(() => {});组件挂载之后执行 和组件数据更新之后执行；
2.useEffect(()=> {},[]);仅挂载完成之后执行一次，=componentDidMount；
3.useEffct(()=> { return () => {}},);组件被卸载之前执行(return 的函数就是被卸载之前执行);
4.结合异步操作
useEffect(() =>{
	(async function() {
		const res =	await getData();
	})()
},[])
```

#### 5.useMemo

> useMemo 的行为类似Vue中的计算属性，可以检测某个值的变化，根据变化值计算新值；
>
> useMemo会缓存计算解惑，如果检测值没有发生变化，即使组件重新渲染，也不会重新计算，此行为可以有助于避免在每个渲染上进行昂贵的计算

```
const value = useMemo(() => {
	return count * 2;
})
```

#### 6.memo

> 性能优化，如果本组件中的数据没有发生变化，阻止组件更新，类似类组件中的 PureComponent 和 shouldComponentUpdate

```
function App(){
	return <div></div>
}
export default memo(App)
```

q s:怎么实现的？

#### 7.useCallback

> 性能优化，缓存函数，使组件重新渲染时得到相同的函数实例

```
```


