import { defineUserConfig } from "vuepress";
import { defaultTheme } from "@vuepress/theme-default";
import { searchPlugin } from '@vuepress/plugin-search'
export default {
    lang: "zh-CN",
    title: "学习笔记",
    dest: "md-notes",
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
                        text: "三、Promise 源码",
                        link: "/javascript/promise.md",
                        children: [],
                    },
                    {
                        text: "四、TypeScript 语言 ",
                        link: "/javascript/typeScript.md",
                        children: [],
                    },
                    {
                        text: "五、JavaScript 性能优化",
                        children: [{
                            text: '1、垃圾回收相关',
                            link: "/javascript/performance.md",
                        },
                        {
                            text: '2、常见代码优化实例',
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
                text: "Vue.js 框架原理",
                // 可折叠的侧边栏
                collapsible: true,
                children: [
                    {
                        text: "一、Vue.js 基础",
                        // link: "/vueframe/basicVueTheory.md",
                        children: [{
                            text: "1、Vue 响应式原理浅析",
                            link: "/vueframe/basicVueTheory.md",
                        },
                        {
                            text: "2、Vue Router 原理及实现",
                            link: "/vueframe/basicVueRouter.md",
                        },
                        {
                            text: "3、Vue VirtualDOM",
                            link: "/vueframe/basicVirtualDOM.md",
                        }
                        ],
                    },
                    {
                        text: "二、Vue 源码浅析",
                        link: "/vueframe/vueSourceCode.md",
                        children: [
                            {
                                text: "1、响应系统",
                                // link: "/vueframe/vueSourceCode.md",
                            },
                            {
                                text: "2、渲染器",
                                // link: "/vueframe/vueSourceCode.md",
                            },
                            {
                                text: "3、组件化",
                                // link: "/vueframe/vueSourceCode.md",
                            },
                            {
                                text: "4、编译器",
                                // link: "/vueframe/vueSourceCode.md",
                            },
                            {
                                text: "5、Diff 算法",
                                // link: "/vueframe/vueSourceCode.md",
                                children: [
                                    {
                                        text: "简单 Diff 算法",
                                        // link: "/vueframe/vueSourceCode.md",
                                    },
                                    {
                                        text: "双端 Diff 算法",
                                        // link: "/vueframe/vueSourceCode.md",
                                    },
                                    {
                                        text: "快速 Diff 算法",
                                        // link: "/vueframe/vueSourceCode.md",
                                    },
                                ]
                            },
                        ],
                    },
                    {
                        text: "三、Vuex 数据流管理以 ",
                        // link: "/vueframe/vueSourceCode.md",
                    },
                    {
                        text: "四、Vue.js 服务端渲染",
                        // link: "/vueframe/vueSourceCode.md",
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
                        link: "/reactframe/virtualDomAndDiff.md",
                        children: [
                            {
                                text: "1、Virtual DOM 及 Diff 算法",
                                link: "/reactframe/virtualDomAndDiff.md",
                            },
                            {
                                text: "2、React Fiber",
                                link: "/reactframe/fiber.md",
                            }
                        ],
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
                text: "Angular 框架学习",
                // 可折叠的侧边栏
                collapsible: true,
                children: [
                    {
                        text: "一、Angular 框架基础",
                        children: [
                            {
                                text: "1、Angular 简介及基础",
                                link: "/angular/basicAngular.one.md",
                            },
                            {
                                text: "2、深入了解 Angular ",
                                link: "/angular/basicAngular.two.md",
                            },
                        ],
                    },
                    {
                        text: "二、Angular 框架进阶",
                        children: [{
                            text: "1、Angular 表单",
                            link: "/angular/basicAngular.form.md",
                        },

                        {
                            text: "2、Angular 路由",
                            link: "/angular/basicAngular.router.md",
                        },
                        ]
                    },
                    {
                        text: "三、Angular 框架高级",
                        children: [
                            {
                                text: "1、Angular HttpClient",
                                link: "/angular/basicAngular.http.md",
                            },
                            {
                                text: "2、Angular RXJS",
                                link: "/angular/angular.rxjs.md",
                            },
                            {
                                text: "3、Angular NGRX",
                                link: "/angular/angular.ngrx.md",
                            },
                            {
                                text: "4、Angular 动画",
                                link: "/angular/angular.animate.md",
                            },
                        ]
                    },
                ],
            },
            {
                text: "常用工具类",
                // 可折叠的侧边栏
                collapsible: true,
                // link: "/commonTools/linux.md",
                children: [
                    {
                        text: "linux 常用命令",
                        link: "/commonTools/linux.md",
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
