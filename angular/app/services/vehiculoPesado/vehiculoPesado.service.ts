import  {Injectable} from "@angular/core";
import  {Http, Response,Headers} from "@angular/http";
import  "rxjs/add/operator/map";
import  {Observable} from "rxjs/Observable";

@Injectable()
export class VehiculoPesadoService {
	public url = "http://localhost/GitHub/colossus-sit/web/app_dev.php/vehiculopesado";
	public identity;
	public token;

	constructor(private _http: Http){}

	getVehiculoPesado(){
		
		return this._http.get(this.url+"/").map(res => res.json());
	}

	register(vehiculoPesado,token){
		
		let json = JSON.stringify(vehiculoPesado);
		let params = "json="+json+"&authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});
		return this._http.post(this.url+"/new", params, {headers: headers})
							  .map(res => res.json());
	}

	deleteVehiculoPesado(token,id){

		let params = "authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});
		return this._http.post(this.url+"/"+id+"/delete", params, {headers: headers})
							  .map(res => res.json());
	}

	showVehiculoPesado(token,id){
		
		let params = "authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});
		return this._http.post(this.url+"/show/"+id, params, {headers: headers})
							  .map(res => res.json());

	}

	showVehiculoPesadoVehiculoId(token,vehiculoId){
		
		let params = "authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});
		return this._http.post(this.url+"/vehiculoPesado/idVehiculo/"+vehiculoId, params, {headers: headers})
							  .map(res => res.json());

	}

	editVehiculoPesado(vehiculoPesado,token){

		let json = JSON.stringify(vehiculoPesado);
		let params = "json="+json+"&authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});
 			return this._http.post(this.url+"/edit", params, {headers: headers})
							  .map(res => res.json());

	}
	
}