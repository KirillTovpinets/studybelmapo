import { Component } from '@angular/core';
import { LoginComponent } from './loginform/loginform.component'

@Component({
  selector: 'study',
  template: '<router-outlet></router-outlet>'
})
export class AppComponent {
	title = 'app';
}
