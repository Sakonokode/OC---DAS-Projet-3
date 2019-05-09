import React from 'react';
import ReactDOM from 'react-dom';

class ProgressBar extends React.Component {

    state = {
        loading: this.props.loading || false,
        percent: this.props.percent || 0
    };

    triggerState() {
        this.setState({
            loading: this.state.loading,
            percent: this.state.percent
        });
    }

    render() {
        let value = this.state.percent.concat('%');
        let duration = '300ms';
        let divStyle = {
            transitionDuration: duration,
            width: value
        };

        return (
            <div className="ui yellow progress progress-bar" data-percent={this.state.percent}>
                <div className="bar" style={divStyle}></div>
            </div>
        );
    }
}

export default ProgressBar;