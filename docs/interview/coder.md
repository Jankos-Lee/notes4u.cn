# CSS 重绘与回流（重排）

## 什么是回流（Reflow/重排）

回流是指浏览器需要**重新计算元素的位置和几何属性**的过程。当页面布局或元素的几何属性发生变化时，就会触发回流。

### 触发回流的常见操作：

1. **改变元素尺寸**：`width`, `height`, `padding`, `margin`, `border`
2. **改变元素位置**：`position`, `top`, `left`, `right`, `bottom`
3. **改变页面布局**：`display`, `float`, `flex`, `grid`
4. **DOM 结构变化**：添加/删除元素，修改文本内容
5. **窗口变化**：窗口大小调整（`resize` 事件）
6. **读取某些属性**：`offsetWidth`, `offsetHeight`, `scrollTop`, `clientWidth` 等

## 什么是重绘（Repaint）

重绘是指当元素的**样式发生变化但不影响布局**时，浏览器需要重新绘制元素的外观。重绘不涉及几何位置计算。

### 触发重绘的常见操作：

1. **改变颜色属性**：`color`, `background-color`, `border-color`
2. **改变背景**：`background-image`, `background-position`
3. **改变边框样式**：`border-style`, `border-radius`
4. **改变阴影**：`box-shadow`, `text-shadow`
5. **改变透明度**：`opacity`
6. **改变可见性**：`visibility`（但注意 `display: none` 会触发回流）

## 关系与区别

```
触发回流 → 必然触发重绘
触发重绘 → 不一定触发回流
```

回流成本比重绘高得多，因为回流会引发整个渲染流程的重新计算。

## 优化策略

### 1. **避免频繁操作 DOM**
```javascript
// 不推荐：多次操作触发多次回流
for (let i = 0; i < 100; i++) {
  element.style.width = i + 'px';
}

// 推荐：批量操作，减少回流次数
element.style.width = '100px';
```

### 2. **使用文档片段或隐藏元素**
```javascript
// 使用文档片段
const fragment = document.createDocumentFragment();
for (let i = 0; i < 100; i++) {
  const div = document.createElement('div');
  fragment.appendChild(div);
}
document.body.appendChild(fragment);

// 或先隐藏元素，操作完成后再显示
element.style.display = 'none';
// 进行DOM操作
element.style.display = 'block';
```

### 3. **避免逐条修改样式**
```javascript
// 不推荐
element.style.width = '100px';
element.style.height = '100px';
element.style.backgroundColor = 'red';

// 推荐：使用class
element.className = 'new-style';

// 或使用cssText
element.style.cssText = 'width: 100px; height: 100px; background: red;';
```

### 4. **避免同步读取布局属性**
```javascript
// 不推荐：强制同步回流（布局抖动）
for (let i = 0; i < boxes.length; i++) {
  const width = boxes[i].offsetWidth; // 读取 → 触发回流
  boxes[i].style.width = width + 10 + 'px'; // 写入 → 再次触发回流
}

// 推荐：批量读取和写入
const widths = [];
for (let i = 0; i < boxes.length; i++) {
  widths[i] = boxes[i].offsetWidth;
}
for (let i = 0; i < boxes.length; i++) {
  boxes[i].style.width = widths[i] + 10 + 'px';
}
```

### 5. **使用 CSS3 硬件加速**
```css
.element {
  transform: translateZ(0); /* 或 translate3d(0,0,0) */
  /* 这将使元素在独立的合成层中渲染，避免影响其他元素 */
}
```

### 6. **优化动画**
```css
/* 不推荐：使用 left/top 进行动画 */
.box {
  position: absolute;
  left: 0;
  transition: left 0.3s;
}

/* 推荐：使用 transform 进行动画（只触发重绘，不触发回流） */
.box {
  position: absolute;
  left: 0;
  transform: translateX(0);
  transition: transform 0.3s;
}
```

## 性能监控

可以使用浏览器开发者工具监控回流重绘：
1. **Performance 面板**：记录页面运行时性能
2. **Rendering 面板**：
   - 开启 "Paint flashing"：高亮显示重绘区域
   - 开启 "Layout Shift Regions"：显示布局偏移区域

## 总结

- **回流**：计算元素位置和大小，成本高
- **重绘**：绘制元素外观，成本相对较低
- **优化核心**：减少DOM操作、批量处理样式、使用CSS3变换替代布局属性、避免布局抖动

理解重绘与回流的机制，可以帮助我们编写性能更高的前端代码，特别是在处理动画、频繁更新的交互场景中。
