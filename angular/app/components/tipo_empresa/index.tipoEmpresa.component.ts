// Importar el núcleo de Angular
import {TipoEmpresaService} from "../../services/tipo_Empresa/tipoEmpresa.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/tipo_empresa/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,TipoEmpresaService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexTipoEmpresaComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public tiposEmpresa;
	

	constructor(
		private _TipoEmpresaService: TipoEmpresaService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._TipoEmpresaService.getTipoEmpresa().subscribe(
				response => {
					this.tiposEmpresa = response.data;
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

	deleteTipoEmpresa(id:string){
		let token = this._loginService.getToken();
		this._TipoEmpresaService.deleteTipoEmpresa(token,id).subscribe(
				response => {
					    this.respuesta= response;
					    console.log(this.respuesta); 
					    this.ngOnInit();
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


}
