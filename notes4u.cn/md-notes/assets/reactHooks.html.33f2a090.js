import{_ as e,o as n,c as i,e as t}from"./app.06465b50.js";const s={},d=t(`<h4 id="_1-usestate" tabindex="-1"><a class="header-anchor" href="#_1-usestate" aria-hidden="true">#</a> 1.useState</h4><blockquote><p>\u8BA9\u51FD\u6570\u5F0F\u7EC4\u4EF6\u4FDD\u5B58\u72B6\u6001\uFF0C\u8BBE\u7F6E\u72B6\u6001\u503C\u65B9\u6CD5\u672C\u8EAB\u662F\u5F02\u6B65\u7684</p></blockquote><div class="language-text ext-text line-numbers-mode"><pre class="language-text"><code>1.\u63A5\u53D7\u552F\u4E00\u7684\u53C2\u6570\uFF0C\u5373\u72B6\u6001\u7684\u521D\u59CB\u503C\u53EF\u4EE5\u662F\u4EFB\u52A1\u6570\u636E\u7C7B\u578B\uFF1B
2.\u8FD4\u56DE\u503C\u4E3A\u4E00\u4E2A\u6570\u7EC4,\u5206\u522B\u4E3A\u72B6\u6001\u7684\u503C\u548C\u8BBE\u7F6E\u72B6\u6001\u7684\u65B9\u6CD5\uFF0C\u7EA6\u5B9A\u8BBE\u7F6E\u72B6\u6001\u503C\u7684\u65B9\u6CD5\u4EE5set \u72B6\u6001\u540D \u547D\u540D\uFF1B
3.\u65B9\u6CD5\u53EF\u4EE5\u88AB\u591A\u6B21\u8C03\u7528\uFF0C\u4EE5\u4FDD\u5B58\u4E0D\u540C\u72B6\u6001\u7684\u503C\uFF1B
4.\u53C2\u6570\u53EF\u4EE5\u662F\u4E00\u4E2A\u51FD\u6570\uFF0C\u51FD\u6570\u8FD4\u56DE\u4EC0\u4E48\u521D\u59CB\u72B6\u6001\u5C31\u662F\u4EC0\u4E48\uFF1B\u51FD\u6570\u53EA\u4F1A\u88AB\u8C03\u7528\u4E00\u6B21\u7528\u5728\u521D\u59CB\u503C\u662F\u52A8\u6001\u503C\u7684\u60C5\u51B5\uFF1B
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h4 id="_2-usereducer" tabindex="-1"><a class="header-anchor" href="#_2-usereducer" aria-hidden="true">#</a> 2.useReducer</h4><blockquote><p>\u8BA9\u51FD\u6570\u578B\u7EC4\u4EF6\u4FDD\u5B58\u72B6\u6001</p></blockquote><div class="language-text ext-text line-numbers-mode"><pre class="language-text"><code>eg:
function reducer(state, action) {
	switch (action.type) {
		case &#39;increment&#39;:
			return state + 1;
		case &#39;decrement&#39;:
			return state - 1;
	}
}
const [count, dispath] = useReducer(reducer, 0);

&lt;button onClick={dispath({type: &#39;increment&#39;})} /&gt;
&lt;button onClick={dispath({type: &#39;decrement&#39;})} /&gt;

</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h4 id="_3-usecontext" tabindex="-1"><a class="header-anchor" href="#_3-usecontext" aria-hidden="true">#</a> 3.useContext</h4><blockquote><p>\u5728\u8DE8\u7EC4\u4EF6\u5C42\u7EA7\u83B7\u53D6\u6570\u636E\u65F6\u7B80\u5316\u83B7\u53D6\u6570\u636E\u65F6\u7684\u4EE3\u7801</p></blockquote><div class="language-text ext-text line-numbers-mode"><pre class="language-text"><code>import React, { createContext, useContext } from &#39;react&#39;;
const countContext = createContext();
function App() {
 return &lt;countContext.Provider value={200}&gt;
 	&lt;Foo /&gt;
 	&lt;/countContext.Provider&gt;
}

function Foo() {
	return &lt;countContext.Consumer&gt;
	{
		value =&gt; &lt;div&gt;{value}&lt;/div&gt;
	}
	&lt;/countContext.Consumer&gt;
}
function Foo() {
	const valueuseContext(countCOntext)
	return &lt;div&gt;{value}&lt;/div&gt;
}
export default App;
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h4 id="_4-useeffect" tabindex="-1"><a class="header-anchor" href="#_4-useeffect" aria-hidden="true">#</a> 4.useEffect</h4><blockquote><p>\u8BA9\u51FD\u6570\u5F0F\u7EC4\u4EF6\u62E5\u6709\u5904\u7406\u526F\u4F5C\u7528\u7684\u80FD\u529B\uFF0C\u7C7B\u4F3C\u751F\u547D\u5468\u671F\u51FD\u6570</p><p>useEffect\u4E2D\u7684\u53C2\u6570\u51FD\u6570\u4E0D\u80FD\u662F\u5F02\u6B65\u51FD\u6570\uFF0C\u56E0\u4E3AuseEffect\u51FD\u6570\u8981\u8FD4\u56DE\u6E05\u7406\u8D44\u6E90\u7684\u51FD\u6570\uFF0C\u5982\u679C\u662F\u5F02\u6B65\u51FD\u6570\u5C31\u53D8\u6210\u4E86\u8FD4\u56DE Promise</p></blockquote><div class="language-text ext-text line-numbers-mode"><pre class="language-text"><code>1.useEffect(() =&gt; {});\u7EC4\u4EF6\u6302\u8F7D\u4E4B\u540E\u6267\u884C \u548C\u7EC4\u4EF6\u6570\u636E\u66F4\u65B0\u4E4B\u540E\u6267\u884C\uFF1B
2.useEffect(()=&gt; {},[]);\u4EC5\u6302\u8F7D\u5B8C\u6210\u4E4B\u540E\u6267\u884C\u4E00\u6B21\uFF0C=componentDidMount\uFF1B
3.useEffct(()=&gt; { return () =&gt; {}},);\u7EC4\u4EF6\u88AB\u5378\u8F7D\u4E4B\u524D\u6267\u884C(return \u7684\u51FD\u6570\u5C31\u662F\u88AB\u5378\u8F7D\u4E4B\u524D\u6267\u884C);
4.\u7ED3\u5408\u5F02\u6B65\u64CD\u4F5C
useEffect(() =&gt;{
	(async function() {
		const res =	await getData();
	})()
},[])
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h4 id="_5-usememo" tabindex="-1"><a class="header-anchor" href="#_5-usememo" aria-hidden="true">#</a> 5.useMemo</h4><blockquote><p>useMemo \u7684\u884C\u4E3A\u7C7B\u4F3CVue\u4E2D\u7684\u8BA1\u7B97\u5C5E\u6027\uFF0C\u53EF\u4EE5\u68C0\u6D4B\u67D0\u4E2A\u503C\u7684\u53D8\u5316\uFF0C\u6839\u636E\u53D8\u5316\u503C\u8BA1\u7B97\u65B0\u503C\uFF1B</p><p>useMemo\u4F1A\u7F13\u5B58\u8BA1\u7B97\u89E3\u60D1\uFF0C\u5982\u679C\u68C0\u6D4B\u503C\u6CA1\u6709\u53D1\u751F\u53D8\u5316\uFF0C\u5373\u4F7F\u7EC4\u4EF6\u91CD\u65B0\u6E32\u67D3\uFF0C\u4E5F\u4E0D\u4F1A\u91CD\u65B0\u8BA1\u7B97\uFF0C\u6B64\u884C\u4E3A\u53EF\u4EE5\u6709\u52A9\u4E8E\u907F\u514D\u5728\u6BCF\u4E2A\u6E32\u67D3\u4E0A\u8FDB\u884C\u6602\u8D35\u7684\u8BA1\u7B97</p></blockquote><div class="language-text ext-text line-numbers-mode"><pre class="language-text"><code>const value = useMemo(() =&gt; {
	return count * 2;
})
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h4 id="_6-memo" tabindex="-1"><a class="header-anchor" href="#_6-memo" aria-hidden="true">#</a> 6.memo</h4><blockquote><p>\u6027\u80FD\u4F18\u5316\uFF0C\u5982\u679C\u672C\u7EC4\u4EF6\u4E2D\u7684\u6570\u636E\u6CA1\u6709\u53D1\u751F\u53D8\u5316\uFF0C\u963B\u6B62\u7EC4\u4EF6\u66F4\u65B0\uFF0C\u7C7B\u4F3C\u7C7B\u7EC4\u4EF6\u4E2D\u7684 PureComponent \u548C shouldComponentUpdate</p></blockquote><div class="language-text ext-text line-numbers-mode"><pre class="language-text"><code>function App(){
	return &lt;div&gt;&lt;/div&gt;
}
export default memo(App)
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>q s:\u600E\u4E48\u5B9E\u73B0\u7684\uFF1F</p><h4 id="_7-usecallback" tabindex="-1"><a class="header-anchor" href="#_7-usecallback" aria-hidden="true">#</a> 7.useCallback</h4><blockquote><p>\u6027\u80FD\u4F18\u5316\uFF0C\u7F13\u5B58\u51FD\u6570\uFF0C\u4F7F\u7EC4\u4EF6\u91CD\u65B0\u6E32\u67D3\u65F6\u5F97\u5230\u76F8\u540C\u7684\u51FD\u6570\u5B9E\u4F8B</p></blockquote><div class="language-text ext-text line-numbers-mode"><pre class="language-text"><code></code></pre><div class="line-numbers" aria-hidden="true"></div></div>`,22),a=[d];function l(c,r){return n(),i("div",null,a)}const v=e(s,[["render",l],["__file","reactHooks.html.vue"]]);export{v as default};
