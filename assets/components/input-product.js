import React, {Component} from "react";
import { toast } from "react-toastify";
import 'react-toastify/dist/ReactToastify.css';
// toast.configure();

export default class InputProduct extends Component{
    constructor(props) {
        super(props);
        this.state = {
            name: '',
            fullName: '',
            rateLimit: '',
            price: ''
        };
        this.handleChangeName = this.handleChangeName.bind(this);
        this.handleChangeFullName = this.handleChangeFullName.bind(this);
        this.handleChangeRateLimit = this.handleChangeRateLimit.bind(this);
        this.handleChangePrice = this.handleChangePrice.bind(this);
        this.postProductData = this.postProductData.bind(this);
        this.onSuccess = this.onSuccess.bind(this);
        this.onError = this.onError.bind(this);

    }

    componentDidMount() {

    }
    post = () => {
        this.postProductData()
            .then(this.onSuccess)
            .catch(this.onError);
    }
    async postProductData() {
        let product = JSON.stringify(this.state);

        let response = await fetch('https://127.0.0.1:8000/api/v1/product', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: product
        });
        let result = await response.json();
        console.log(result);
        alert(result);

        // if (!response.ok) {
        //     throw new Error (`Error, ${result}`)
        // }
        return result;
    }

    onSuccess = (data) => {

    }

    onError = (error) => {

    }

    handleChangeName(event) {
        const newValue = event.target.value;
        this.setState({ name: newValue })
    }
    handleChangeFullName(event) {
        const newValue = event.target.value;
        this.setState({ fullName: newValue })
    }
    handleChangeRateLimit(event) {
        const newValue = event.target.value;
        this.setState({ rateLimit: +newValue })
    }
    handleChangePrice(event) {
        const newValue = event.target.value;
        this.setState({ price: +newValue })
    }

    render () {
        return (
            <div>
                <li className="collection-header"><h4>Ввод тарифного плана</h4></li>
                <div className="row">
                    <form className="col s6">

                        <div className="row">
                            <div className="input-field col s12">
                                <input id="name" type="text" className="validate" value={this.state.name} onChange={this.handleChangeName}></input>
                                <label htmlFor="name">Краткое наименование</label>
                            </div>
                        </div>
                        <div className="row">
                            <div className="input-field col s12">
                                <input id="fullName" type="text" className="validate" value={this.state.fullName} onChange={this.handleChangeFullName}></input>
                                <label htmlFor="fullName">Полное наименование</label>
                            </div>
                        </div>
                        <div className="row">
                            <div className="input-field col s6">
                                <input id="rateLimit" type="text" className="validate" value={this.state.rateLimit} onChange={this.handleChangeRateLimit}></input>
                                <label htmlFor="rateLimit">Скорость</label>
                            </div>
                            <div className="input-field col s6">
                                <input id="price" type="text" className="validate" value={this.state.price} onChange={this.handleChangePrice}></input>
                                <label htmlFor="price">Стоимость</label>
                            </div>
                        </div>

                        <button className="btn waves-effect waves-light" type="submit" name="action" onClick={ () => this.postProductData() }>Submit</button>

                    </form>
                </div>

            </div>
        );
    }
}