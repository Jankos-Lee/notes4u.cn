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
                        // link: '/javascript/function.md',
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
        ],
    }),
};
