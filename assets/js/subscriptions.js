import React from 'react';
import ReactDOM from 'react-dom';
import ProgressBar from './progress_bar';

class SubscriptionButton extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            isSubscribed: this.props.isSubscribed || false,
            dataSeance: this.props.dataSeance || null,
            totalSubscribers : this.props.totalSubscribers || 0,
            maxSubscribers : this.props.maxSubscribers || 0,
            percent : this.props.percent || 0,
            movieDuration: this.props.movieDuration || 0
        };
    }

    handleClick = (e) => {

        e.preventDefault();

        if (this.state.isSubscribed === false) {

            const str = "/seance/";
            const str1 = str.concat(this.state.dataSeance);
            const url = str1.concat("/subscribe");

            const test = `/seance/${str1}/subscribe`;

            const subcribe = fetch(url, {
                method: 'GET'
            }).then(function (response) {
                console.log(response.status);
                if (response.status >= 400) {
                    throw new Error("Bad response from server / action : subscribe");
                }

                return response.json();
            });

            const isSubscribed = this.state.isSubscribed;
            const totalSubscribers = this.state.totalSubscribers + 1;
            const percent = totalSubscribers * 100 / this.state.maxSubscribers;

            this.setState({isSubscribed: !isSubscribed});
            this.setState({totalSubscribers});
            this.setState({percent});

        } else {

            const str = "/seance/";
            const str1 = str.concat(this.state.dataSeance);
            const url = str1.concat("/unsubscribe");

            const unsubscribe = fetch(url, {
                method: 'GET'
            }).then(function (response) {
                console.log(response.status);
                if (response.status >= 400) {
                    throw new Error("Bad response from server / action : unsubscribe");
                }

                return response.json();
            });

            const isSubscribed = this.state.isSubscribed;
            const totalSubscribers = this.state.totalSubscribers - 1;
            const percent = totalSubscribers * 100 / this.state.maxSubscribers;

            this.setState({isSubscribed: !isSubscribed});
            this.setState({totalSubscribers});
            this.setState({percent});
        }

    };

    render() {
        return (
            <div>
                <div>
                    <button className={this.state.isSubscribed ? "ui button red bottom attached button btn-more-detail" :
                        "ui button green bottom attached button btn-more-detail"}
                            onClick={this.handleClick}>
                        <i className={this.state.isSubscribed ? "minus icon" : "add icon"}/>
                        &nbsp;
                        {this.state.isSubscribed ? "Desinscription" : "Inscription"}
                    </button>
                    <ProgressBar percent={this.state.percent}></ProgressBar>
                </div>
                <div className="extra content extra-content">
                    <span className="left floated">
                        <i className="clock outline icon"></i>
                        {this.state.movieDuration}
                    </span>
                    <span className="right floated">
                        {this.state.totalSubscribers} / {this.state.maxSubscribers} Places
                    </span>
                </div>
            </div>
        );
    }
}

document.querySelectorAll('span.react-subscription').forEach(function (span) {
    const isSubscribed = span.dataset.isSubscribed;
    const dataSeance = +span.dataset.seance;
    const percent = +span.dataset.percent;
    const totalSubscribers = +span.dataset.totalSubscribers;
    const maxSubscribers = +span.dataset.maxSubscribers;
    const movieDuration = span.dataset.movieDuration;
    ReactDOM.render(<SubscriptionButton
        isSubscribed={isSubscribed}
        dataSeance={dataSeance}
        percent={percent}
        totalSubscribers={totalSubscribers}
        maxSubscribers={maxSubscribers}
        movieDuration={movieDuration}
    />, span);
});


