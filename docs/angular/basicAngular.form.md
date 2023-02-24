### 1. 表单

在 Angular 中，表单有两种类型，分别为模板驱动和模型驱动。

#### 1.1 模板驱动

##### 1.1.1 概述

表单的控制逻辑写在组件模板中，适合简单的表单类型。

##### 1.1.2 快速上手

1. 引入依赖模块 FormsModule 

   ```javascript
   import { FormsModule } from "@angular/forms"
   
   @NgModule({
     imports: [FormsModule],
   })
   export class AppModule {}
   ```

2. 将 DOM 表单转换为 ngForm

   ```html
   <form #f="ngForm" (submit)="onSubmit(f)"></form>
   ```

3. 声明表单字段为 ngModel

   ```html
   <form #f="ngForm" (submit)="onSubmit(f)">
     <input type="text" name="username" ngModel />
     <button>提交</button>
   </form>
   ```

4. 获取表单字段值

   ```javascript
   import { NgForm } from "@angular/forms"
   
   export class AppComponent {
     onSubmit(form: NgForm) {
       console.log(form.value)
     }
   }
   ```

5. 表单分组

   ```html
   <form #f="ngForm" (submit)="onSubmit(f)">
     <div ngModelGroup="user">
       <input type="text" name="username" ngModel />
     </div>
     <div ngModelGroup="contact">
       <input type="text" name="phone" ngModel />
     </div>
     <button>提交</button>
   </form>
   ```

##### 1.1.3 表单验证

- required 必填字段
- minlength 字段最小长度
- maxlength 字段最大长度
- pattern 验证正则 例如：pattern="\d" 匹配一个数值

```html
<form #f="ngForm" (submit)="onSubmit(f)">
  <input type="text" name="username" ngModel required pattern="\d" />
  <button>提交</button>
</form>
```

```javascript
export class AppComponent {
  onSubmit(form: NgForm) {
    // 查看表单整体是否验证通过
    console.log(form.valid)
  }
}
```

```html
<!-- 表单整体未通过验证时禁用提交表单 -->
<button type="submit" [disabled]="f.invalid">提交</button>
```

在组件模板中显示表单项未通过时的错误信息。

```html
<form #f="ngForm" (submit)="onSubmit(f)">
  <input #username="ngModel" />
  <div *ngIf="username.touched && !username.valid && username.errors">
    <div *ngIf="username.errors.required">请填写用户名</div>
    <div *ngIf="username.errors.pattern">不符合正则规则</div>
  </div>
</form>
```

指定表单项未通过验证时的样式。

```css
input.ng-touched.ng-invalid {
  border: 2px solid red;
}
```

#### 1.2 模型驱动

##### 1.2.1 概述

表单的控制逻辑写在组件类中，对验证逻辑拥有更多的控制权，适合复杂的表单的类型。

在模型驱动表单中，表单字段需要是 FormControl 类的实例，实例对象可以验证表单字段中的值，值是否被修改过等等


一组表单字段构成整个表单，整个表单需要是 FormGroup 类的实例，它可以对表单进行整体验证。

1. FormControl：表单组中的一个表单项
2. FormGroup：表单组，表单至少是一个 FormGroup
3. FormArray：用于复杂表单，可以动态添加表单项或表单组，在表单验证时，FormArray 中有一项没通过，整体没通过。

##### 1.2.2 快速上手

1. 引入 ReactiveFormsModule

   ```javascript
   import { ReactiveFormsModule } from "@angular/forms"
   
   @NgModule({
     imports: [ReactiveFormsModule]
   })
   export class AppModule {}
   ```

2. 在组件类中创建 FormGroup 表单控制对象

   ```javascript
   import { FormControl, FormGroup } from "@angular/forms"
   
   export class AppComponent {
     contactForm: FormGroup = new FormGroup({
       name: new FormControl(),
       phone: new FormControl()
     })
   }
   ```

3. 关联组件模板中的表单

   ```html
   <form [formGroup]="contactForm" (submit)="onSubmit()">
     <input type="text" formControlName="name" />
     <input type="text" formControlName="phone" />
     <button>提交</button>
   </form>
   ```

4. 获取表单值

   ```javascript
   export class AppComponent {
     onSubmit() {
       console.log(this.contactForm.value)
     }
   }
   ```

5. 设置表单默认值

   ```javascript
   contactForm: FormGroup = new FormGroup({
     name: new FormControl("默认值"),
     phone: new FormControl(15888888888)
   })
   ```

6. 表单分组

   ```javascript
   contactForm: FormGroup = new FormGroup({
     fullName: new FormGroup({
       firstName: new FormControl(),
       lastName: new FormControl()
     }),
     phone: new FormControl()
   })
   ```

   ```html
   <form [formGroup]="contactForm" (submit)="onSubmit()">
     <div formGroupName="fullName">
       <input type="text" formControlName="firstName" />
       <input type="text" formControlName="lastName" />
     </div>
     <input type="text" formControlName="phone" />
     <button>提交</button>
   </form>
   ```

   ```javascript
   onSubmit() {
     console.log(this.contactForm.value.name.username)
     console.log(this.contactForm.get(["name", "username"])?.value)
   }
   ```

##### 1.2.3 FormArray

需求：在页面中默认显示一组联系方式，通过点击按钮可以添加更多联系方式组。

```javascript
import { Component, OnInit } from "@angular/core"
import { FormArray, FormControl, FormGroup } from "@angular/forms"
@Component({
  selector: "app-root",
  templateUrl: "./app.component.html",
  styles: []
})
export class AppComponent implements OnInit {
  // 表单
  contactForm: FormGroup = new FormGroup({
    contacts: new FormArray([])
  })

  get contacts() {
    return this.contactForm.get("contacts") as FormArray
  }

  // 添加联系方式
  addContact() {
    // 联系方式
    const myContact: FormGroup = new FormGroup({
      name: new FormControl(),
      address: new FormControl(),
      phone: new FormControl()
    })
    // 向联系方式数组中添加联系方式
    this.contacts.push(myContact)
  }

  // 删除联系方式
  removeContact(i: number) {
    this.contacts.removeAt(i)
  }

  ngOnInit() {
    // 添加默认的联系方式
    this.addContact()
  }

  onSubmit() {
    console.log(this.contactForm.value)
  }
}
```

```html
<form [formGroup]="contactForm" (submit)="onSubmit()">
  <div formArrayName="contacts">
    <div
      *ngFor="let contact of contacts.controls; let i = index"
      [formGroupName]="i"
    >
      <input type="text" formControlName="name" />
      <input type="text" formControlName="address" />
      <input type="text" formControlName="phone" />
      <button (click)="removeContact(i)">删除联系方式</button>
    </div>
  </div>
  <button (click)="addContact()">添加联系方式</button>
  <button>提交</button>
</form>
```

##### 1.2.4 内置表单验证器

1. 使用内置验证器提供的验证规则验证表单字段

   ```javascript
   import { FormControl, FormGroup, Validators } from "@angular/forms"
   
   contactForm: FormGroup = new FormGroup({
     name: new FormControl("默认值", [
       Validators.required,
       Validators.minLength(2)
     ])
   })
   ```

2. 获取整体表单是否验证通过

   ```javascript
   onSubmit() {
     console.log(this.contactForm.valid)
   }
   ```

   ```html
   <!-- 表单整体未验证通过时禁用表单按钮 -->
   <button [disabled]="contactForm.invalid">提交</button>
   ```

3. 在组件模板中显示为验证通过时的错误信息

   ```javascript
   get name() {
     return this.contactForm.get("name")!
   }
   ```

   ```html
   <form [formGroup]="contactForm" (submit)="onSubmit()">
     <input type="text" formControlName="name" />
     <div *ngIf="name.touched && name.invalid && name.errors">
       <div *ngIf="name.errors.required">请填写姓名</div>
       <div *ngIf="name.errors.maxlength">
         姓名长度不能大于
         {{ name.errors.maxlength.requiredLength }} 实际填写长度为
         {{ name.errors.maxlength.actualLength }}
       </div>
     </div>
   </form>
   ```

##### 1.2.5 自定义同步表单验证器

1. 自定义验证器的类型是 TypeScript 类
2. 类中包含具体的验证方法，验证方法必须为静态方法
3. 验证方法有一个参数 control，类型为 AbstractControl。其实就是 FormControl 类的实例对象的类型
4. 如果验证成功，返回 null
5. 如果验证失败，返回对象，对象中的属性即为验证标识，值为 true，标识该项验证失败
6. 验证方法的返回值为 ValidationErrors | null

```javascript
import { AbstractControl, ValidationErrors } from "@angular/forms"

export class NameValidators {
  // 字段值中不能包含空格
  static cannotContainSpace(control: AbstractControl): ValidationErrors | null {
    // 验证未通过
    if (/\s/.test(control.value)) return { cannotContainSpace: true }
    // 验证通过
    return null
  }
}
```

```javascript
import { NameValidators } from "./Name.validators"

contactForm: FormGroup = new FormGroup({
  name: new FormControl("", [
    Validators.required,
    NameValidators.cannotContainSpace
  ])
})
```

```html
<div *ngIf="name.touched && name.invalid && name.errors">
	<div *ngIf="name.errors.cannotContainSpace">姓名中不能包含空格</div>
</div>
```

##### 1.2.6 自定义异步表单验证器

```javascript
import { AbstractControl, ValidationErrors } from "@angular/forms"
import { Observable } from "rxjs"

export class NameValidators {
  static shouldBeUnique(control: AbstractControl): Promise<ValidationErrors | null> {
    return new Promise(resolve => {
      if (control.value == "admin") {
         resolve({ shouldBeUnique: true })
       } else {
         resolve(null)
       }
    })
  }
}
```

```javascript
contactForm: FormGroup = new FormGroup({
    name: new FormControl(
      "",
      [
        Validators.required
      ],
      NameValidators.shouldBeUnique
    )
  })
```

```html
<div *ngIf="name.touched && name.invalid && name.errors">
  <div *ngIf="name.errors.shouldBeUnique">用户名重复</div>
</div>
<div *ngIf="name.pending">正在检测姓名是否重复</div>
```

##### 1.2.7 FormBuilder

创建表单的快捷方式。

1. `this.fb.control`：表单项
2. `this.fb.group`：表单组，表单至少是一个 FormGroup
3. `this.fb.array`：用于复杂表单，可以动态添加表单项或表单组，在表单验证时，FormArray 中有一项没通过，整体没通过。

```javascript
import { FormBuilder, FormGroup, Validators } from "@angular/forms"

export class AppComponent {
  contactForm: FormGroup
  constructor(private fb: FormBuilder) {
    this.contactForm = this.fb.group({
      fullName: this.fb.group({
        firstName: ["😝", [Validators.required]],
        lastName: [""]
      }),
      phone: []
    })
  }
}
```

##### 1.2.8 练习

1. 获取一组复选框中选中的值

   ```html
   <form [formGroup]="form" (submit)="onSubmit()">
     <label *ngFor="let item of Data">
       <input type="checkbox" [value]="item.value" (change)="onChange($event)" />
       {{ item.name }}
     </label>
     <button>提交</button>
   </form>
   ```

   ```javascript
   import { Component } from "@angular/core"
   import { FormArray, FormBuilder, FormGroup } from "@angular/forms"
   interface Data {
     name: string
     value: string
   }
   @Component({
     selector: "app-checkbox",
     templateUrl: "./checkbox.component.html",
     styles: []
   })
   export class CheckboxComponent {
     Data: Array<Data> = [
       { name: "Pear", value: "pear" },
       { name: "Plum", value: "plum" },
       { name: "Kiwi", value: "kiwi" },
       { name: "Apple", value: "apple" },
       { name: "Lime", value: "lime" }
     ]
     form: FormGroup
   
     constructor(private fb: FormBuilder) {
       this.form = this.fb.group({
         checkArray: this.fb.array([])
       })
     }
   
     onChange(event: Event) {
       const target = event.target as HTMLInputElement
       const checked = target.checked
       const value = target.value
       const checkArray = this.form.get("checkArray") as FormArray
   
       if (checked) {
         checkArray.push(this.fb.control(value))
       } else {
         const index = checkArray.controls.findIndex(
           control => control.value === value
         )
         checkArray.removeAt(index)
       }
     }
   
     onSubmit() {
       console.log(this.form.value)
     }
   }
   
   ```

2. 获取单选框中选中的值

   ```javascript
   export class AppComponent {
     form: FormGroup
   
     constructor(public fb: FormBuilder) {
       this.form = this.fb.group({ gender: "" })
     }
   
     onSubmit() {
       console.log(this.form.value)
     }
   }
   ```

   ```html
   <form [formGroup]="form" (submit)="onSubmit()">
     <input type="radio" value="male" formControlName="gender" /> Male
     <input type="radio" value="female" formControlName="gender" /> Female
     <button type="submit">Submit</button>
   </form>
   ```

##### 1.2.9 其他

1. patchValue：设置表单控件的值（可以设置全部，也可以设置其中某一个，其他不受影响）
2. setValue：设置表单控件的值 (设置全部，不能排除任何一个)
3. valueChanges：当表单控件的值发生变化时被触发的事件
4. reset：表单内容置空