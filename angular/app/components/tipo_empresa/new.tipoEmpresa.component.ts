// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {TipoEmpresaService} from '../../services/tipo_Empresa/tipoEmpresa.service';
import {TipoEmpresa} from '../../model/tipo_Empresa/TipoEmpresa';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/tipo_Empresa/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,TipoEmpresaService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewTipoEmpresaComponent {
	public tipoEmpresa: TipoEmpresa;
	public errorMessage;
	public respuesta;

	constructor(
		private _TipoEmpresaService:TipoEmpresaService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.tipoEmpresa = new TipoEmpresa(null, "");
	}

	onSubmit(){
		let token = this._loginService.getToken();
		this._TipoEmpresaService.register(this.tipoEmpresa,token).subscribe(
			response => {
				this.respuesta = response;
				console.log(this.respuesta);

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
