import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PersonalInfoComponent } from '../personalInfo/personalInfo.component';
import { GeneralInfoComponent } from '../personalInfo/generalInfo/generalInfo.component';
import { ProfInfoComponent } from '../personalInfo/prof/profInfo.component';
import { PrivateInfoComponent } from '../personalInfo/private/privateInfo.component';
import { HistoryInfoComponent } from '../personalInfo/historyInfo/historyInfo.component';
import { OtherInfoComponent } from '../personalInfo/otherInfo/otherInfo.component';
import { PostDiplomaInfoComponent } from '../personalInfo/postDiploma/postDiploma.component';
import { ArrivalsInfoComponent } from '../personalInfo/arrivals/arrivals.component';

import { AccordionModule, 
  ModalModule, 
  TabsModule, 
  BsDatepickerModule, 
  TooltipModule, 
  BsDropdownModule, 
  ProgressbarModule  } from 'ngx-bootstrap';

@NgModule({
  imports: [
    CommonModule,
    AccordionModule, 
    ModalModule, 
    TabsModule, 
    BsDatepickerModule, 
    TooltipModule, 
    BsDropdownModule, 
    ProgressbarModule
  ],
  declarations: [
    PersonalInfoComponent,
    GeneralInfoComponent,
    ProfInfoComponent,
    PrivateInfoComponent,
    HistoryInfoComponent,
    OtherInfoComponent,
    PostDiplomaInfoComponent,
    ArrivalsInfoComponent,
  ],
  entryComponents: [PersonalInfoComponent],
})
export class PersonalModule { }
