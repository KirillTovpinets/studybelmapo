import { NgModule } 			from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AppComponent } 		from './app.component';
import { LoginComponent } 		from './loginform.component';
import { MainComponent } 		from './main.component';
import { MenuComponent } 		from './menu.component';
import { NavbarComponent } 		from './navbar.component';
import { AccordionComponent } 	from './accordion.component';
import { StudListComponent } 	from './studList.component';

const routes: Routes = [
	{ path: 'login', component: LoginComponent },
	{ path: '', redirectTo: '/login', pathMatch: 'full' },
	{ 
		path: 'main', 
		component: MainComponent,
		children: [
			{ path: '', redirectTo: 'studlist', pathMatch: 'full' },
			{ path: 'studlist', component: StudListComponent},
		]
	},

]

@NgModule({
	imports: [RouterModule.forRoot(routes)],
	exports: [RouterModule]
})

export class AppRoutingModule{}