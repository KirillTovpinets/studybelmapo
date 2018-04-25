import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MenuComponent } from '../menu/menu.component';
import { NavbarComponent } from '../navbar/navbar.component';
import { MobilemenuComponent } from '../mobilemenu/mobilemenu.component';
import { DepMenuComponent } from '../dep-menu/dep-menu.component';
import { DepMobMenuComponent } from '../dep-mob-menu/dep-mob-menu.component';
import { RouterModule } from '@angular/router';
@NgModule({
  imports: [
    CommonModule,
    RouterModule
  ],
  declarations: [
    MenuComponent,
    NavbarComponent,
    MobilemenuComponent,
    DepMenuComponent,
    DepMobMenuComponent
  ],
  exports: [
    MenuComponent,
    NavbarComponent,
    MobilemenuComponent,
    DepMenuComponent,
    DepMobMenuComponent
  ]
})
export class MenuModule { }
