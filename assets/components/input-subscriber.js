import React, {Component} from "react";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import '../lib/materialize.css';
import {path} from '../index';

export default class InputSubscriber extends Component {
    constructor(props) {
        super(props);
        this.state = {
            name: '',
            street: '',
            house: '',
            apartment: '',
            addressOptions: []
        };
        this.handleChangeName = this.handleChangeName.bind(this);
        this.handleChangeStreet = this.handleChangeStreet.bind(this);
        this.handleChangeHouse = this.handleChangeHouse.bind(this);
        this.handleChangeApartment = this.handleChangeApartment.bind(this);
        this.getAddressOptions = this.getAddressOptions.bind(this);
        this.postSubscriberData = this.postSubscriberData.bind(this);

    }

    async postSubscriberData() {
        let subscriber = JSON.stringify(this.state);

        let response = await fetch(path + 'subscriber', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: subscriber
        });
        let result = await response.json();

        if (!response.ok) {

            toast.error(result);

            let oldValues = JSON.parse(subscriber);
            this.setState({
                name: oldValues.name,
                street: oldValues.street,
                house: oldValues.house,
                apartment: oldValues.apartment,
            })
        }
        else {
            toast.success('Success!');

            this.setState({
                name: result.name,
                street: result.street,
                house: result.house,
                apartment: result.apartment,
            });
        }
    }

    async getAddressOptions(data) {

        if ((data.length % 3) !== 0) return;

        let requestData = {
            "option": data
        };

        let request = JSON.stringify(requestData);

        let response = await fetch('https://127.0.0.1:8000/get-address', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: request
        });
        let result = await response.json();

        if (!response.ok) {
            console.log(result);
        }
        else {
            // toast.success('Success!');
            this.setState({ addressOptions: result })
        }
    }

    handleChangeName(event) {
        const newValue = event.target.value;
        this.setState({ name: newValue })
    }
    handleChangeStreet(event) {
        const newValue = event.target.value;
        this.setState({ street: newValue })
        this.getAddressOptions(this.state.street)
            .then()
            .catch()
    }
    handleChangeHouse(event) {
        const newValue = event.target.value;
        this.setState({ house: newValue })
    }
    handleChangeApartment(event) {
        const newValue = event.target.value;
        this.setState({ apartment: newValue })
    }

    render () {

        const addressOptions = this.state.addressOptions.map((address, index) => {
            return <option key={index} value={address[0] + ', ' + address[1]}>{address[1]}</option>;
        });

        return (
            <div>
                <ToastContainer/>
                <li className="collection-header"><h4>Ввод абонента</h4></li>
                <div className="row">
                    <div className="col s6">

                        <div className="row">
                            <div className="input-field col s12">
                                <input
                                    id="name"
                                    type="text"
                                    className="validate"
                                    placeholder="ФИО"
                                    value={this.state.name}
                                    onChange={this.handleChangeName}>
                                </input>
                            </div>
                        </div>
                        <div className="row">
                            <div className="input-field col s12">
                                <input
                                    id="street"
                                    type="text"
                                    list="options"
                                    className="validate"
                                    placeholder="Город, улица"
                                    value={this.state.street}
                                    onChange={this.handleChangeStreet}>
                                </input>
                                <datalist id="options">
                                    {addressOptions}
                                </datalist>
                            </div>
                        </div>
                        <div className="row">
                            <div className="input-field col s6">
                                <input
                                    id="house"
                                    type="text"
                                    className="validate"
                                    placeholder="Дом"
                                    value={this.state.house}
                                    onChange={this.handleChangeHouse}>
                                </input>
                            </div>
                            <div className="input-field col s6">
                                <input
                                    id="apartment"
                                    type="text"
                                    className="validate"
                                    placeholder="Квартира"
                                    value={this.state.apartment}
                                    onChange={this.handleChangeApartment}>
                                </input>
                            </div>
                        </div>

                        <button className="btn waves-effect waves-light" name="action" onClick={ () => this.postSubscriberData() }>Submit</button>

                    </div>
                </div>

            </div>
        );
    }
}