// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {TipoEmpresaService} from '../../services/tipo_Empresa/tipoEmpresa.service';
import {TipoEmpresa} from '../../model/tipo_Empresa/TipoEmpresa';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/tipo_Empresa/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,TipoEmpresaService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class TipoEmpresaEditComponent implements OnInit{ 
	public errorMessage;
	public tipoEmpresa : TipoEmpresa;
	public id;
	public respuesta;

	constructor(
		private _loginService: LoginService,
		private _TipoEmpresaService: TipoEmpresaService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.tipoEmpresa = new TipoEmpresa(null,"");


		let token = this._loginService.getToken();

			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._TipoEmpresaService.showTipoEmpresa(token,this.id).subscribe(

						response => {
							this.tipoEmpresa = response.data;
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
		this._TipoEmpresaService.editTipoEmpresa(this.tipoEmpresa,token).subscribe(
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





