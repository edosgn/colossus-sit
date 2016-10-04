// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {DepartamentoService} from '../../services/departamento/departamento.service';
import {MunicipioService} from "../../services/municipio/municipio.service";
import {Departamento} from '../../model/departamento/Departamento';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/municipio/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,DepartamentoService,MunicipioService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class MunicipioEditComponent implements OnInit{ 
	public errorMessage;
	public departamento : Departamento;
	public id;
	public respuesta;
	public municipios;

	constructor(
		private _loginService: LoginService,
		private _DepartamentoService: DepartamentoService,
		private _MunicipioService: MunicipioService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.departamento = new Departamento(null, "",null);


		let token = this._loginService.getToken();

			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._MunicipioService.showMunicipio(token,this.id).subscribe(

						response => {
							this.departamento = response.data;
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
		console.log(token);

		this._DepartamentoService.editDepartamento(this.departamento,token).subscribe(
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





