import { NgModule } 				from '@angular/core';
import { Routes, RouterModule } 	from '@angular/router';

import { AppComponent } 			from './app.component';
import { LoginComponent } 			from './loginform/loginform.component';
import { MainComponent } 			from './main/main.component';
import { MenuComponent } 			from './menu/menu.component';
import { FillDataComponent } 		from './fillData/fillData.component';
import { NavbarComponent } 			from './navbar/navbar.component';
import { AccordionComponent } 		from './accordion.component';
import { StudListComponent } 		from './studList/studList.component';
import { SearchStudentComponent } 	from './registry/searchStudent.component';
import { AddStudentComponent } 		from './addStudent/addStudent.component';
import { ReportComponent } 			from './report/report.component';
import { OrderComponent } 			from './order/order.component';
import { AuthGuard } 				from "./auth.guard";

import { SirnameComponent } from './registry/sirname/sirname.component';
import { GenderComponent } from './registry/gender/gender.component';
import { AgeComponent } from './registry/age/age.component';
import { EstablishmentComponent } from './registry/establishment/establishment.component';
import { OrganizationComponent } from './registry/organization/organization.component';
import { AppointmentComponent } from './registry/appointment/appointment.component';
import { SpecialityComponent } from './registry/speciality/speciality.component';
import { QualificationComponent } from './registry/qualification/qualification.component';
import { CategoryComponent } from './registry/category/category.component';
import { ChooseCourseComponent } from './FillData/chooseCourse.component';
import { ChooseStudentComponent } from './FillData/chooseStudent.component';
import { HelpComponent } from './help/help.component';
import { AdminComponent } from './admin/admin.component';
import { TableContentComponent } from './table-content/table-content.component';
const routes: Routes = [
	{ path: 'login', component: LoginComponent },
	{ 
		path: 'admin', 
		component: AdminComponent,
		canActivate: [AuthGuard],
		children: [
			{ path: 'table/:table', component: TableContentComponent},
			{ path: '', redirectTo: 'studlist', pathMatch: 'full' },
			{ path: 'studlist', component: StudListComponent},
			{ path: 'help', component: HelpComponent},
			{ 
				path: 'list', 
				component: SearchStudentComponent,
				children: [
					{ path: '', redirectTo:'sirname', pathMatch: 'full'},
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
			// { path: 'addDoctor', component: AddStudentComponent},
			{ 
				path: 'addDoctor', 
				component: FillDataComponent,
				children: [
					{ path: '', redirectTo: 'chooseCourse', pathMatch: 'full'},
					{ path: 'chooseCourse', component: ChooseCourseComponent},
					{ path: 'chooseStudent/:id', component: ChooseStudentComponent},
					{ path: 'addNew/:id', component: AddStudentComponent},
				]
			},
			{ path: 'reports', component: ReportComponent},
			{ path: 'orders', component: OrderComponent}
		]
	},
	{ path: '', redirectTo: '/login', pathMatch: 'full' },
	{ 
		path: 'main', 
		component: MainComponent,
		canActivate: [AuthGuard],
		children: [
			{ path: '', redirectTo: 'studlist', pathMatch: 'full' },
			{ path: 'studlist', component: StudListComponent},
			{ path: 'help', component: HelpComponent},
			{ 
				path: 'list', 
				component: SearchStudentComponent,
				children: [
					{ path: '', redirectTo:'sirname', pathMatch: 'full'},
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
			// { path: 'addDoctor', component: AddStudentComponent},
			{ 
				path: 'addDoctor', 
				component: FillDataComponent,
				children: [
					{ path: '', redirectTo: 'chooseCourse', pathMatch: 'full'},
					{ path: 'chooseCourse', component: ChooseCourseComponent},
					{ path: 'chooseStudent/:id', component: ChooseStudentComponent},
					{ path: 'addNew/:id', component: AddStudentComponent},
				]
			},
			{ path: 'reports', component: ReportComponent},
			{ path: 'orders', component: OrderComponent}

		]
	},

]

@NgModule({
	imports: [RouterModule.forRoot(routes)],
	exports: [RouterModule],
	providers: [AuthGuard]
})

export class AppRoutingModule{}