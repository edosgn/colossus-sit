// Importar el núcleo de Angular
import {VarianteService} from "../../services/variante/variante.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import {TramiteService} from '../../services/tramite/tramite.service';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Variante} from '../../model/variante/variante';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/variante/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,VarianteService,TramiteService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class VarianteEditComponent implements OnInit{ 
	public errorMessage;
	public variante : Variante;
	public id;
	public respuesta;
	public tramites;

	constructor(
		private _TramiteService: TramiteService,
		private _loginService: LoginService,
		private _VarianteService: VarianteService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){} 

	ngOnInit(){	

		this.variante = new Variante(null,null,""); 
		let token = this._loginService.getToken();
		this._TramiteService.getTramite().subscribe(
				response => {
					this.tramites = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);
		
			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._VarianteService.showVariante(token,this.id).subscribe(

						response => {
							let data = response.data;
							this.variante = new Variante(data.id,data.tramite.id, data.nombre);
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
		this._VarianteService.editVariante(this.variante,token).subscribe(
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





