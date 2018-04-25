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
import { TabsModule, BsDatepickerModule } from 'ngx-bootstrap';
import { FormsModule } from '@angular/forms';
import { Ng2AutoCompleteModule } from 'ng2-auto-complete';
import { TranslatePipe } from '../translate.pipe';
@NgModule({
  imports: [
    CommonModule,
    TabsModule.forRoot(),
    FormsModule,
    Ng2AutoCompleteModule,
    BsDatepickerModule.forRoot(),
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
    TranslatePipe,
  ],
  exports: [
    PersonalInfoComponent,
    GeneralInfoComponent,
    ProfInfoComponent,
    PrivateInfoComponent,
    HistoryInfoComponent,
    OtherInfoComponent,
    PostDiplomaInfoComponent,
    ArrivalsInfoComponent,
    ],
  entryComponents: [PersonalInfoComponent]
})
export class PersonInfoModule { }
