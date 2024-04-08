import React, {Component} from "react";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import '../lib/materialize.css';
import {path} from '../index';

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

    }

    async postProductData() {
        let product = JSON.stringify(this.state);

        let response = await fetch(path + 'product', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: product
        });
        let result = await response.json();

        if (!response.ok) {
            toast.error(result);
            this.setState(JSON.parse(product))
        }
        else {
            toast.success('Success!');
            this.setState(result);
        }
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
                <ToastContainer />
                <li className="collection-header"><h4>Ввод тарифного плана</h4></li>
                <div className="row">
                    <div className="col s6">

                        <div className="row">
                            <div className="input-field col s12">
                                <input
                                    id="name"
                                    type="text"
                                    className="validate"
                                    placeholder="Краткое наименование"
                                    value={this.state.name}
                                    onChange={this.handleChangeName}>
                                </input>
                            </div>
                        </div>
                        <div className="row">
                            <div className="input-field col s12">
                                <input
                                    id="fullName"
                                    type="text"
                                    className="validate"
                                    placeholder="Полное наименование"
                                    value={this.state.fullName}
                                    onChange={this.handleChangeFullName}>
                                </input>
                            </div>
                        </div>
                        <div className="row">
                            <div className="input-field col s6">
                                <input
                                    id="rateLimit"
                                    type="number"
                                    className="validate"
                                    placeholder="Скорость"
                                    value={this.state.rateLimit}
                                    onChange={this.handleChangeRateLimit}>
                                </input>
                            </div>
                            <div className="input-field col s6">
                                <input
                                    id="price"
                                    type="number"
                                    className="validate"
                                    placeholder="Стоимость"
                                    value={this.state.price}
                                    onChange={this.handleChangePrice}>
                                </input>
                            </div>
                        </div>

                        <button className="btn waves-effect waves-light" name="action" onClick={ () => this.postProductData() }>Submit</button>

                    </div>
                </div>

            </div>
        );
    }
}