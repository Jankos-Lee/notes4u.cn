import { defineUserConfig } from "vuepress";
import { defaultTheme } from "@vuepress/theme-default";
import { searchPlugin } from '@vuepress/plugin-search'
export default {
    lang: "zh-CN",
    title: "学习笔记",
    dest: "dist",
    base: 'md-notes',
    description: "前端笔记、JavaScript、Vue、React", //  HTML 中表现为一个 <meta> 标签
    port: 3000, // dev 端口
    theme: defaultTheme({
        // 在这里进行配置
        navbar: [
            // NavbarItem
            {
                text: "前端笔记",
                link: "http://notes4u.cn/",
            },
            // NavbarGroup
            {
                text: "分类",
                children: ["test1", "test2"],
            },
        ],
        sidebar: [
            // SidebarItem
            {
                text: "JavaScript 深度剖析",
                collapsible: true, // 可折叠的侧边栏
                children: [
                    // SidebarItem
                    {
                        text: "一、函数式编程范式",
                        link: "/javascript/function.md",
                        children: [
                            {
                                text: "1、函数式编程范式基础",
                                link: "/javascript/function.md",
                            },
                            {
                                text: "2、函数式编程范式进阶",
                                link: "/javascript/advancedFunction.md",
                            }
                        ],
                    },
                    {
                        text: "二、JavaScript 异步编程",
                        link: "/javascript/async.md",
                        children: [],
                    },
                    {
                        text: "三、Promise源码",
                        children: [],
                    },
                    {
                        text: "四、ECMAScript 新特性",
                        children: [],
                    },
                    {
                        text: "五、TypeScript 语言 ",
                        link: "/javascript/typeScript.md",
                        children: [],
                    },
                    {
                        text: "六、JavaScript 性能优化",
                        children: [{
                            text: '1、内存管理',
                        },
                        {
                            text: '2、垃圾回收与常见GC算法',
                        },
                        {
                            text: '3、V8引擎的垃圾回收',
                        },
                        {
                            text: '4、代码优化实例',
                        },
                    ],
                    },
                ],
            },
            {
                text: "前端工程化相关",
                // 可折叠的侧边栏
                collapsible: true,
                children: [
                    {
                        text: "一、脚手架工具",
                        link: "/engineering/engineeringTools.md",
                        children: [],
                    },
                    {
                        text: "二、自动化构建",
                        link: "/engineering/automateBuild.md",
                        children: [],
                    },
                ],
            },
            {
                text: "Vue.js框架原理",
                // 可折叠的侧边栏
                collapsible: true,
                children: [
                    {
                        text: "一、Vue.js基础",
                        link: "/vueframe/basicVue.md",
                        children: [],
                    },
                    {
                        text: "二、Vue源码浅析",
                        link: "/vueframe/vueSourceCode.md",
                        children: [],
                    },
                ],
            },
            {
                text: "React.js框架原理",
                // 可折叠的侧边栏
                collapsible: true,
                children: [
                    {
                        text: "一、React核心原理及核心源码",
                        link: "/reactframe/reactCore.md",
                        children: [],
                    },
                    {
                        text: "二、React数据流方案",
                        link: "/reactframe/reactDataFlow.md",
                        children: [],
                    },
                    {
                        text: "三、React Hooks以及组件性能优化",
                        link: "/reactframe/reactHooks.md",
                        children: [
                            {
                                text: "1、React Hooks 语法 ",
                                link: "/reactframe/reactHooks.md",
                            }
                        ],
                    },
                    {
                        text: "四、React服务端渲染",
                        link: "/reactframe/reactServiceSideRender.md",
                        children: [],
                    },
                ],
            },
            {
                text: "前端面试题汇总",
                // 可折叠的侧边栏
                // collapsible: true,
                link: "/interview/feInterview.md",
                // children: [
                //     {
                //         text: "1.Vue.js基础",
                //         link: "/interview/feInterview.md",
                //         children: [],
                //     },
                // ],
            },
        ],
    }),
    plugins: [
        searchPlugin({
            locales: {
                '/': {
                    placeholder: '',
                },
                '/zh/': {
                    placeholder: '搜索',
                },
            },
        }),
    ],
};
