import { Component, OnInit, Input } from '@angular/core';
import { NavbarService } from './navbar.service';
import { Router } from '@angular/router';
import { ShareService } from './services/share.service';

declare var jquery: any;
declare var $:any;
@Component({
	selector: 'navbar',
	templateUrl: 'templates/navbar.component.html',
	styles: [`
		.navbar-right li:hover{
			cursor:pointer;
		}
	`],
	providers: [NavbarService]
})

export class NavbarComponent implements OnInit{
	constructor(private navInfo: NavbarService,
				private router: Router,
				private menuManip: ShareService){

	}
	loginInfo:any;
	message:boolean;
	toggle:boolean = false;
    logedUser: any;
	lbd:any = {
		navbar_menu_visible: 0,
	    navbar_initialized: false,
	    initRightMenu: function(){
	    	var navbar = $('nav').find('.navbar-collapse').first().clone(true);

            var sidebar = $('.sidebar');
            var sidebar_color = sidebar.data('color');

            var logo = sidebar.find('.logo').first();
            var logo_content = logo[0].outerHTML;

            var ul_content = '';

            navbar.attr('data-color',sidebar_color);

            //add the content from the regular header to the right menu
            navbar.children('ul').each(function(){
                var content_buff = $(this).outerHTML;
                ul_content = ul_content + content_buff;
            });

            // add the content from the sidebar to the right menu
            var content_buff = sidebar.find('.nav').html();
            ul_content = ul_content + content_buff;


            ul_content = '<div class="sidebar-wrapper">' +
                            '<ul class="nav navbar-nav">' +
                                ul_content +
                            '</ul>' +
                          '</div>';

            var navbar_content = logo_content + ul_content;

            navbar.html(navbar_content);

            $('body').append(navbar);

            var background_image = sidebar.data('image');
            if(background_image != undefined){
                navbar.css('background',"url('" + background_image + "')")
                       .removeAttr('data-nav-image')
                       .addClass('has-image');
            }
	    }
	}
	ngOnInit():void{
		this.navInfo.getInfo().subscribe(response => this.loginInfo = response.json());
        this.logedUser = localStorage.getItem("currentUser");
		// if ($(window).width() <= 1200) {
		// 	this.lbd.initRightMenu();
		// }
	}
	Logout():void{
		this.navInfo.logout().subscribe(response => this.router.navigate(['/login']))
	}
	ToggleMenu(e){
		if(this.lbd.navbar_menu_visible !== undefined && this.lbd.navbar_menu_visible == 1) {
            $('html').removeClass('nav-open');
            this.lbd.navbar_menu_visible = 0;
            $('#bodyClick').remove();
             setTimeout(function(){
             	this.toggle = false;
             }, 400);

        } else {
            setTimeout(function(){
                this.toggle = true;
            }, 430);

            var div = '<div id="bodyClick"></div>';
            $(div).appendTo("body").click(function() {
                $('html').removeClass('nav-open');
                this.navbar_menu_visible = 0;
                $('#bodyClick').remove();
                 setTimeout(function(){
                    this.toggle = false;
                 }, 400);
            });

            $('html').addClass('nav-open');
            this.lbd.navbar_menu_visible = 1;

        }
	}
}