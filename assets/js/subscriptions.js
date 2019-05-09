import React from 'react';
import ReactDOM from 'react-dom';
import ProgressBar from './progress_bar';

class SubscriptionButton extends React.Component {

    state = {
        isSubscribed: this.props.isSubscribed || false,
        dataSeance: this.props.dataSeance || null
    };

    handleClick = (e) => {

        e.preventDefault();

        if (this.state.isSubscribed === false) {

            const str = "/seance/";
            const str1 = str.concat(this.state.dataSeance);
            const url = str1.concat("/subscribe");

            const like = fetch(url, {
                method: 'GET'
            }).then(function (response) {
                console.log(response.status);
                if (response.status >= 400) {
                    throw new Error("Bad response from server / action : subscribe");
                }

                return response.json();
            });

            const isSubscribed = this.state.isSubscribed;
            const dataSeance = this.state.dataSeance;

            this.setState({dataSeance: dataSeance});
            this.setState({isSubscribed: !isSubscribed});

        } else {

            const str = "/seance/";
            const str1 = str.concat(this.state.dataSeance);
            const url = str1.concat("/unsubscribe");

            const like = fetch(url, {
                method: 'GET'
            }).then(function (response) {
                console.log(response.status);
                if (response.status >= 400) {
                    throw new Error("Bad response from server / action : unsubscribe");
                }

                return response.json();
            });

            const isSubscribed = this.state.isSubscribed;
            const dataSeance = this.state.dataSeance;

            this.setState({dataSeance: dataSeance});
            this.setState({isSubscribed: !isSubscribed});
        }

    };

    render() {
        return (
            <button className={this.state.isSubscribed ? "ui button red bottom attached button btn-more-detail" :
                "ui button green bottom attached button btn-more-detail"}
                    onClick={this.handleClick}>
                <i className={this.state.isSubscribed ? "minus icon" : "add icon"}/>
                &nbsp;
                {this.state.isSubscribed ? "Inscription" : "Inscription"}
            </button>
        );
    }
}

document.querySelectorAll('span.react-subscription').forEach(function (span) {
    const isSubscribed = span.dataset.isSubscribed;
    const dataSeance = +span.dataset.seance;
    ReactDOM.render(<SubscriptionButton isSubscribed={isSubscribed} dataSeance={dataSeance}/>, span);
});

document.querySelectorAll('div.progress-bar').forEach(function (div) {
    const percent = div.dataset.percent;
    ReactDOM.render(<ProgressBar percent={percent}/>, div);
});