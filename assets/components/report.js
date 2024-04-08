import React, {Component} from "react";
import {toast, ToastContainer} from "react-toastify";
import {path} from '../index';

export default class  Report extends Component  {
    constructor(props) {
        super(props);
        this.state = {
            flag: 0,
            connectDate: '',
            address: '',
            products: [],
            productUuid: '',
            startDate: '',
            finalDate: '',
            contracts: []
        };
        this.handleChangeConnectDate = this.handleChangeConnectDate.bind(this);
        this.handleChangeAddress = this.handleChangeAddress.bind(this);
        this.handleChangeProduct = this.handleChangeProduct.bind(this);
        this.handleChangeStartDate = this.handleChangeStartDate.bind(this);
        this.handleChangeFinalDate = this.handleChangeFinalDate.bind(this);
        this.getInitialData = this.getInitialData.bind(this);
        this.getReport = this.getReport.bind(this);
        this.makeReportByDate = this.makeReportByDate.bind(this);
        this.makeReportByAddress = this.makeReportByAddress.bind(this);
        this.makeReportByProduct = this.makeReportByProduct.bind(this);
        this.makeReportByPeriod = this.makeReportByPeriod.bind(this);
        this.renderBaseScreen = this.renderBaseScreen.bind(this);
        this.renderReport = this.renderReport.bind(this);
    }

    componentDidMount() {
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
    }

    handleChangeConnectDate(event) {
        const newValue = event.target.value;
        this.setState({ connectDate: newValue })
    }
    handleChangeAddress(event) {
        const newValue = event.target.value;
        this.setState({ address: newValue })
    }
    handleChangeProduct(event) {
        const newValue = event.target.value;
        this.setState({ productUuid: newValue })
    }
    handleChangeStartDate(event) {
        const newValue = event.target.value;
        this.setState({ startDate: newValue })
    }
    handleChangeFinalDate(event) {
        const newValue = event.target.value;
        this.setState({ finalDate: newValue })
    }

    async getReport(name, requestBody) {

        let response = await fetch(path + name, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: requestBody
        });
        let result = await response.json();
        if (!response.ok) {

            toast.error(result, {autoClose: 5000});

            this.setState({
                contracts: [],
                flag: 0
            })
        }
        else {
            let contractList = result.items;

            this.setState(
                {
                    contracts: contractList,
                    flag: 1
                });
        }
        return result;
    }

    closeReport() {
        this.setState({ flag: 0 });
    }

    makeReportByDate() {
        let data = {
            "date": this.state.connectDate
        };
        let json = JSON.stringify(data);

        this.getReport('contracts-by-date', json)
            .then()
            .catch()
    }
    makeReportByAddress() {
        let data = {
            "option": this.state.address
        };
        let json = JSON.stringify(data);

        this.getReport('contracts-by-address', json)
            .then()
            .catch()
    }
    makeReportByProduct() {
        let data = {
            "uuid": this.state.productUuid
        };
        let json = JSON.stringify(data);

        this.getReport('contracts-by-product', json)
            .then()
            .catch()
    }
    makeReportByPeriod() {
        let data = {
            "startDate": this.state.startDate,
            "finalDate": this.state.finalDate
        };
        let json = JSON.stringify(data);

        this.getReport('contracts-by-period', json)
            .then()
            .catch()
    }


    render () {

        let {flag} = this.state;
        let items = {};

        if (flag === 0) items = this.renderBaseScreen();
        if (flag === 1) items = this.renderReport();

        return (
            <div>
                <ToastContainer />
                {items}
            </div>
        );
    }

    renderBaseScreen() {

        let productOptions = []

        if (this.state.products) {
            productOptions = this.state.products.map((product) => {
                return <option key={product.uuid} value={product.uuid}>{product.name}</option>;
            });
        }

        return (
            <div>
                <div className="row">
                    <div className="col s6 m6">
                        <div className="card horizontal">
                            <div className="card-stacked">
                                <div className="card-content">
                                    <div>
                                        <p>Отчет “подключения по датам”</p>
                                    </div>
                                    <div className="input-field">
                                        <input
                                            id="connectDate"
                                            type="date"
                                            className="datepicker"
                                            placeholder="Дата отчета"
                                            value={this.state.connectDate}
                                            onChange={this.handleChangeConnectDate}>
                                        </input>
                                    </div>
                                </div>
                                <div className="card-action">
                                    <button className="btn waves-effect waves-light"
                                            onClick={ () => this.makeReportByDate() }>Выполнить
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div className="card horizontal">
                            <div className="card-stacked">
                                <div className="card-content">
                                    <div>
                                        <p>Отчет “подключения по адресам”</p>
                                    </div>
                                    <div className="input-field">
                                        <input
                                            id="address"
                                            type="text"
                                            className="validate"
                                            placeholder="Адрес"
                                            value={this.state.address}
                                            onChange={this.handleChangeAddress}>
                                        </input>
                                    </div>
                                </div>
                                <div className="card-action">
                                    <button className="btn waves-effect waves-light"
                                            onClick={ () => this.makeReportByAddress() }>Выполнить
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="row">
                    <div className="col s6 m6">
                        <div className="card horizontal">
                            <div className="card-stacked">
                                <div className="card-content">
                                    <div>
                                        <p>Отчет “По тарифному плану”</p>
                                    </div>
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
                                <div className="card-action">
                                    <button className="btn waves-effect waves-light"
                                            onClick={ () => this.makeReportByProduct() }>Выполнить
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div className="card horizontal">
                            <div className="card-stacked">
                                <div className="card-content">
                                    <div>
                                        <p>Отчет “Подключения за период</p>
                                    </div>
                                    <div className="input-field">
                                        <input
                                            id="startDate"
                                            type="date"
                                            className="datepicker"
                                            placeholder="Дата отчета"
                                            value={this.state.startDate}
                                            onChange={this.handleChangeStartDate}>
                                        </input>
                                    </div>
                                    <div className="input-field">
                                        <input
                                            id="finalDate"
                                            type="date"
                                            className="datepicker"
                                            placeholder="Дата отчета"
                                            value={this.state.finalDate}
                                            onChange={this.handleChangeFinalDate}>
                                        </input>
                                    </div>
                                </div>
                                <div className="card-action">
                                    <button className="btn waves-effect waves-light"
                                            onClick={ () => this.makeReportByPeriod() }>Выполнить
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    };

    renderReport () {

        let contractItems = []

        if (this.state.contracts) {
            contractItems = this.state.contracts.map((contract) => {
                let contractDate = new Date(contract.signedAt);

                return <li className="row" key={contract.uuid}>
                    <div className="col s4">
                        {contractDate.toLocaleDateString()}
                    </div>
                    <div className="col s4">
                        {contract.productName}
                    </div>
                    <div className="col s4">
                        {contract.subscriberName}
                    </div>
                </li>;
            });
        }

        return (
            <div>
                <div className="row">
                    <button className="btn waves-effect waves-light"
                            onClick={ () => this.closeReport() }>Закрыть
                    </button>
                </div>

                <ul className="collection">
                    {contractItems}
                </ul>
            </div>
        );
    }
}
