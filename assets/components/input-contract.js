import React, {Component} from "react";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import '../lib/materialize';
import {path} from '../index';

export default class InputContract extends Component {
    constructor(props) {
        super(props);
        this.state = {
            products: [],
            subscribers: [],
            productUuid: '',
            subscriberUuid: '',
            signedAt: ''
        };
        this.handleChangeProduct = this.handleChangeProduct.bind(this);
        this.handleChangeSubscriber = this.handleChangeSubscriber.bind(this);
        this.handleChangeSignedAt = this.handleChangeSignedAt.bind(this);
        this.getInitialData = this.getInitialData.bind(this);
        this.postContractData = this.postContractData.bind(this);
    }
    componentDidMount() {
        M.FormSelect.init(document.querySelectorAll('select'));
        this.getInitialData()
            .then()
            .catch();
    }
    async getInitialData() {
        let response = await fetch(path + 'products', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            }
        });
        let productList = await response.json();
        this.setState({products: productList.items});

        response = await fetch(path + 'subscribers', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            }
        });
        let subscriberList = await response.json();
        this.setState({subscribers: subscriberList.items});
    }


    async postContractData() {

        let {productUuid, subscriberUuid, signedAt} = this.state;
        let contract = JSON.stringify(
            {productUuid, subscriberUuid, signedAt});

        let response = await fetch(path + 'contract', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: contract
        });
        let result = await response.json();

        if (!response.ok) {
            toast.error(result, {autoClose: 5000});

            let oldValues = JSON.parse(contract)
            this.setState({
                productUuid: oldValues.productUuid,
                subscriberUuid: oldValues.subscriberUuid,
                signedAt: oldValues.signedAt
            })
        }
        else {
            toast.success('Success!', {autoClose: 5000});

            let newDate = result.signedAt.format("yyyy-mm-dd");
            this.setState(
                {
                    productUuid: result.productUuid,
                    subscriberUuid: result.subscriberUuid,
                    signedAt: newDate
                });
        }
        return result;
    }

    handleChangeProduct(event) {
        const newValue = event.target.value;
        this.setState({ productUuid: newValue })
    }
    handleChangeSubscriber(event) {
        const newValue = event.target.value;
        this.setState({ subscriberUuid: newValue })
    }
    handleChangeSignedAt(event) {
        const newValue = event.target.value;
        this.setState({ signedAt: newValue })
    }

    render () {

        let productOptions = []
        let subscriberOptions = []

        if (this.state.products) {
            productOptions = this.state.products.map((product) => {
                return <option key={product.uuid} value={product.uuid}>{product.name}</option>;
            });
        }

        if (this.state.subscribers) {
            subscriberOptions = this.state.subscribers.map((subscriber) => {
                return <option key={subscriber.uuid} value={subscriber.uuid}>{subscriber.name}</option>;
            });
        }

        return (
            <div>
                <ToastContainer />
                <li className="collection-header"><h4>Подключение абонента</h4></li>
                <div className="row">
                    <div className="col s6">

                        <div className="row">
                            <div className="input-field col s12">
                                <select
                                    className="browser-default"
                                    name="product"
                                    onChange={this.handleChangeProduct}>
                                    <option value="" disabled selected>Выберите тарифный план</option>
                                    {productOptions}
                                </select>
                            </div>
                        </div>

                        <div className="row">
                            <div className="input-field col s12">
                                <select
                                    className="browser-default"
                                    name="subscriber"
                                    onChange={this.handleChangeSubscriber}>
                                    <option value="" disabled selected>Выберите абонента</option>
                                    {subscriberOptions}
                                </select>
                            </div>
                        </div>

                        <div className="row">
                            <div className="input-field col s12">
                                <input
                                    id="signedAt"
                                    type="date"
                                    className="datepicker"
                                    value={this.state.signedAt}
                                    onChange={this.handleChangeSignedAt}>
                                </input>
                                <label>Дата подключения</label>
                            </div>
                        </div>

                        <button className="btn waves-effect waves-light" name="action" onClick={ () => this.postContractData() }>Submit</button>

                    </div>
                </div>

            </div>
        );
    }
}
