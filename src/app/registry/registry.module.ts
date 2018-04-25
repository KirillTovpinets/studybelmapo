import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SirnameComponent } from '../registry/sirname/sirname.component';
import { GenderComponent } from '../registry/gender/gender.component';
import { AgeComponent } from '../registry/age/age.component';
import { EstablishmentComponent } from '../registry/establishment/establishment.component';
import { OrganizationComponent } from '../registry/organization/organization.component';
import { AppointmentComponent } from '../registry/appointment/appointment.component';
import { SpecialityComponent } from '../registry/speciality/speciality.component';
import { QualificationComponent } from '../registry/qualification/qualification.component';
import { CategoryComponent } from '../registry/category/category.component';
import { PreloaderComponent } from '../preloader/preloader.component';
import { TabsModule, AccordionModule } from 'ngx-bootstrap';
@NgModule({
  imports: [
    CommonModule,
    TabsModule,
    AccordionModule
  ],
  declarations: [
    SirnameComponent,
    GenderComponent,
    AgeComponent,
    EstablishmentComponent,
    OrganizationComponent,
    AppointmentComponent,
    SpecialityComponent,
    QualificationComponent,
    CategoryComponent,
    PreloaderComponent
  ],
  exports: [
    SirnameComponent,
    GenderComponent,
    AgeComponent,
    EstablishmentComponent,
    OrganizationComponent,
    AppointmentComponent,
    SpecialityComponent,
    QualificationComponent,
    CategoryComponent,
    PreloaderComponent
  ]
})
export class RegistryModule { }
