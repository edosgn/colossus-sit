// Importar el núcleo de Angular
import {LineaService} from "../../services/linea/linea.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import {MarcaService} from '../../services/marca/marca.service';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Linea} from '../../model/linea/linea';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/linea/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,LineaService,MarcaService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class LineaEditComponent implements OnInit{ 
	public errorMessage;
	public linea : Linea;
	public id;
	public respuesta;
	public marcas;

	constructor(
		private _MarcaService: MarcaService,
		private _loginService: LoginService,
		private _LineaService: LineaService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	

		this.linea = new Linea(null,null, "", null);
		let token = this._loginService.getToken();
		this._MarcaService.getMarca().subscribe(
				response => {
					this.marcas = response.data;
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

			this._LineaService.showLinea(token,this.id).subscribe(

						response => {
							let data = response.data;
							this.linea = new Linea(data.id,data.marca.id, data.nombre, data.codigoMt);
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
		this._LineaService.editLinea(this.linea,token).subscribe(
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





