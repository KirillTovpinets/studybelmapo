//Modules
import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';
//Components
import { StudListComponent } from './studList.component';
//Services
import { InfoService } from './studList.service';

import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { PersonalInfoService } from './personalInfo.service';
import { PersonalInfoComponent } from './personalInfo.component';
import { BsModalService } from "ngx-bootstrap/modal";


@Component({
	selector: 'dashboard',
	templateUrl: 'templates/main.component.html',
})

export class MainComponent{
	
}