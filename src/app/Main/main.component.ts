//Modules
import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';
//Components
import { StudListComponent } from '../studList/studList.component';
//Services
import { InfoService } from '../studList/studList.service';

import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import { PersonalInfoService } from '../personalInfo/personalInfo.service';
import { PersonalInfoComponent } from '../personalInfo/personalInfo.component';
import { BsModalService } from "ngx-bootstrap/modal";


@Component({
	selector: 'dashboard',
	templateUrl: './main.component.html',
})

export class MainComponent{
}