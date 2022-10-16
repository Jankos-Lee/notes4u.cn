import { defineUserConfig } from "vuepress";
import { defaultTheme } from "@vuepress/theme-default";
export default {
    lang: "zh-CN",
    title: "学习笔记",
    description: "这是我的第一个 VuePress 站点",
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
                text: 'JavaScript 深度剖析',
                // 可折叠的侧边栏
                collapsible: true,
                children: [
                    // SidebarItem
                    {
                        text: '1.函数式编程范式',
                        link: '/javascript/function.md',
                        children: [],
                    },
                    {
                        text: '2.JavaScript 异步编程',
                        children: [],
                    },
                    {
                        text: '3.Promise源码',
                        children: [],
                    },
                    {
                        text: '4.ECMAScript 新特性',
                        children: [],
                    },
                    {
                        text: '5.TypeScript 语言 ',
                        children: [],
                    },
                    {
                        text: '6.JavaScript 性能优化',
                        children: [],
                    },
                ],
            },
            {
                text: '前端工程化相关',
                 // 可折叠的侧边栏
                collapsible: true,
                children:[
                    {
                        text: '1.脚手架工具',
                        link: '/engineering/engineeringTools.md',
                        children: [],
                    }, 
                    {
                        text: '2.自动化构建',
                        link: '/engineering/automateBuild.md',
                        children: [],
                    }, 
                ]
            },
            {
                text: 'Vue.js框架原理',
                 // 可折叠的侧边栏
                collapsible: true,
                children:[
                    {
                        text: '1.Vue.js基础',
                        link: '/vueframe/basicVue.md',
                        children: [],
                    }, 
                    {
                        text: '2.Vue源码浅析',
                        link: '/vueframe/vueSourceCode.md',
                        children: [],
                    }, 
                ]
            },
            {
                text: 'React.js框架原理',
                 // 可折叠的侧边栏
                collapsible: true,
                children:[
                    {
                        text: '1.React核心原理及核心源码',
                        link: '/reactframe/reactCore.md',
                        children: [],
                    }, 
                    {
                        text: '2.React数据流方案',
                        link: '/reactframe/reactDataFlow.md',
                        children: [],
                    }, 
                    {
                        text: '3.React Hooks以及组件性能优化',
                        link: '/reactframe/reactHooks.md',
                        children: [],
                    }, 
                    {
                        text: '4.React服务端渲染',
                        link: '/reactframe/reactServiceSideRender.md',
                        children: [],
                    }, 
                ]
            }
        ],
    }),
};
