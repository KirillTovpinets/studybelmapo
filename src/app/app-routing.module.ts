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
import { OrderComponent } from './order.component';
import { AuthGuard } from "./auth.guard";

import { SirnameComponent } from './searchComponents/sirname.component';
import { GenderComponent } from './searchComponents/gender.component';
import { AgeComponent } from './searchComponents/age.component';
import { EstablishmentComponent } from './searchComponents/establishment.component';
import { OrganizationComponent } from './searchComponents/organization.component';
import { AppointmentComponent } from './searchComponents/appointment.component';
import { SpecialityComponent } from './searchComponents/speciality.component';
import { QualificationComponent } from './searchComponents/qualification.component';
import { CategoryComponent } from './searchComponents/category.component';

const routes: Routes = [
	{ path: 'login', component: LoginComponent },
	{ path: '', redirectTo: '/login', pathMatch: 'full' },
	{ 
		path: 'main', 
		component: MainComponent,
		// canActivate: [AuthGuard],
		children: [
			{ path: '', redirectTo: 'studlist', pathMatch: 'full' },
			{ path: 'studlist', component: StudListComponent},
			{ 
				path: 'list', 
				component: SearchStudentComponent,
				children: [
					{ path: 'sirname', component: SirnameComponent },
					{ path: 'gender', component: GenderComponent },
					{ path: 'age', component: AgeComponent },
					{ path: 'education', component: EstablishmentComponent },
					{ path: 'organization', component: OrganizationComponent },
					{ path: 'appointment', component: AppointmentComponent },
					{ path: 'speciality', component: SpecialityComponent },
					{ path: 'qualification', component: QualificationComponent },
					{ path: 'category', component: CategoryComponent }
					
				]
			},
			{ path: 'addDoctor', component: AddStudentComponent},
			{ path: 'reports', component: ReportComponent},
			{ path: 'orders', component: OrderComponent},

		]
	},

]

@NgModule({
	imports: [RouterModule.forRoot(routes)],
	exports: [RouterModule],
	providers: [AuthGuard]
})

export class AppRoutingModule{}