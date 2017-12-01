import { SearchSirnameService } from './searchComponents/services/searchSirname.service';
import { GetListService } from "./searchComponents/services/getPersonList.service";
import { List } from "./searchComponents/List.class";
export class MainClass{
	isLoading: boolean = false;
	EstOffset: number = 0;
	EstLimit: number = 30;

	ListOffset: number = 0;
	ListLimit: number = 30;

	requestDataParams:any = {};

	constructor(public search: SearchSirnameService,
				public establService: GetListService){}
	Search(event:any, establ:List): void{
		if (event.target.value === "") {
			establ.searchResult = [];
			return;
		}
		establ.searchValue = event.target.value;
		this.search.searchPerson(establ.searchValue).then(data => {
			establ.searchResult = data.json();
		});
	}

	estAjaxLoad(table:string, establs: List[], fieldParam?:string): void{
		this.isLoading = true;
		this.EstOffset += this.EstLimit;
		this.requestDataParams = {
			listLimit: this.ListLimit, 
			listOffset: this.ListOffset
		};
		if (fieldParam !== undefined) {
			this.requestDataParams.table = fieldParam;
		}
		console.log(table);
		console.log(fieldParam);
		this.establService.getList(this.EstLimit, this.EstOffset, table, this.requestDataParams).then(data => {
			console.log(data._body);
			for(let obj of data.json().data){
				establs.push(new List());
				establs[establs.length-1].limit = this.ListLimit;
				establs[establs.length-1].offset = this.ListOffset;
				establs[establs.length-1].id = +obj.id;
				establs[establs.length-1].name = obj.name;
				establs[establs.length-1].total = obj.Total;
				establs[establs.length-1].setList(obj.List);;
			}
			this.isLoading = false;
		});
	}

	ajaxLoad($event:any, establ:List, table: string, fieldParam?:string): void{
		if(establ.canLoad){
			if($event.target.scrollTop < establ.scrollCounter){
				establ.offset += 30;
				establ.scrollCounter += 200;
				this.requestDataParams = {
					listLimit: establ.limit, 
					listOffset: establ.offset, 
					estId: establ.id
				};
				if (fieldParam !== undefined) {
					this.requestDataParams.table = fieldParam;
				}
				this.establService.getList(0, 0, table, this.requestDataParams).then(data => {
					console.log(data._body);	
					if (data.json().data.length === 0 || data.json().data[0].List.length === 0) {
						establ.canLoad = false;
					}else{
						establ.setList(data.json().data[0].List);	
					}
				});
			}
		}
	}

	SearchEstablishment(event:any, searchEst:List[], table: string, fieldParam?:string):void{
		if (event.target.value === "") {
			searchEst = [];
			return;
		}
		this.requestDataParams = { 
			name: event.target.value, 
			listLimit: this.ListLimit,
			listOffset: this.ListOffset 
		};
		if (fieldParam !== undefined) {
			this.requestDataParams.table = fieldParam;
		}
		this.establService.getList(50, 0, table, this.requestDataParams).then(data => {
			console.log(data._body);
			for (var i = 0; i < data.json().data.length; i++) {
				searchEst[i] = new List();
				searchEst[i].limit = this.ListLimit;
				searchEst[i].offset = this.ListOffset;
				searchEst[i].name = data.json().data[i].name;
				searchEst[i].total = data.json().data[i].Total;
				searchEst[i].setList(data.json().data[i].List);;
			}
		});
	}
}