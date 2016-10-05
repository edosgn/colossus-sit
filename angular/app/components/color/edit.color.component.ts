// Importar el núcleo de Angular
import {ColorService} from "../../services/color/color.service";
import {LoginService} from "../../services/login.service";
import {Color} from '../../model/color/color';
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/color/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,ColorService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class ColorEditComponent implements OnInit{ 
	public errorMessage;
	public color : Color;
	public id;
	public respuesta;

	constructor(
		private _loginService: LoginService,
		private _ColorService: ColorService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.color = new Color(null,"");
		let token = this._loginService.getToken();

			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._ColorService.showColor(token,this.id).subscribe(

						response => {
							this.color = response.data;
						},
						error => {
								this.errorMessage = <any>error;

								if(this.errorMessage != null){
									console.log(this.errorMessage);
									alert("Error en la petición");
								}
							}

					);
	  
	} 


	onSubmit(){
		let token = this._loginService.getToken();
		this._ColorService.editColor(this.color,token).subscribe(
			response => {
				this.respuesta = response;
			error => {
					this.errorMessage = <any>error;
					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}

		});
	}


}





