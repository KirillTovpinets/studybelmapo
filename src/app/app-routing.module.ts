import { NgModule } 			from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AppComponent } 		from './app.component';
import { LoginComponent } 		from './loginform.component';
import { MainComponent } 		from './main.component';
import { MenuComponent } 		from './menu.component';
import { NavbarComponent } 		from './navbar.component';
import { AccordionComponent } 	from './accordion.component';
import { StudListComponent } 	from './studList.component';
import { SearchStudentComponent } from './searchStudent.component';
import { AddStudentComponent } from './addStudent.component';
import { ReportComponent } from './report.component';
import { SirnameComponent } from './searchComponents/sirname.component';

const routes: Routes = [
	{ path: 'login', component: LoginComponent },
	{ path: '', redirectTo: '/login', pathMatch: 'full' },
	{ 
		path: 'main', 
		component: MainComponent,
		children: [
			{ path: '', redirectTo: 'studlist', pathMatch: 'full' },
			{ path: 'studlist', component: StudListComponent},
			{ 
				path: 'list', 
				component: SearchStudentComponent,
				children: [
					{ path: 'sirname', component: SirnameComponent },
				]
			},
			{ path: 'addDoctor', component: AddStudentComponent},
			{ path: 'reports', component: ReportComponent},
		]
	},

]

@NgModule({
	imports: [RouterModule.forRoot(routes)],
	exports: [RouterModule]
})

export class AppRoutingModule{}