import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'translate'
})
export class TranslatePipe implements PipeTransform {

  translations = {
		"ResidPlace" : "Место пребывания",
		"FormEduc" : "Форма обучения",
		"Status" : "Статус",
		"country" : "Страна",
		"region" : "Регион",
		"district" : "Район",
		"sovet" : "Сельсовет",
		"tip" : "Тип населённого пункта",
		"MarkId" : "Оценка",
		"Faculty" : "Факультет",
		"ee" : "Учреждение образования",
		"citizenship" : "Гражданство",
		"appointment" : "Должность",
		"qualification_add" : "Квалификация (доп.)",
		"qualification_main" : "Квалификация (осн.)",
		"qualification_other" : "Квалификация (другие)",
		"organization" : "Организация",
		"speciality_doct" : "Специальность (докт.)",
		"speciality_retraining" : "Специальность (переподг.)",
		"speciality_other" : "Специальность (другие)",
		"department" : "Отдел",
		"faculty" : "Факультет",
  }

  transform(value: any, args?: any): any {
    return this.translations[value];  
  }

}
