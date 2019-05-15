import React from 'react';
import ReactDOM from 'react-dom';

class ProgressBar extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            loading: this.props.loading || false,
            percent: this.props.percent || 0
        };
    }

    componentWillReceiveProps(nextProps, nextContext) {
        this.setState({
            ...nextProps
        })
    }

    render() {
        let value = this.state.percent.toString().concat('%');
        let duration = '300ms';
        let divStyle = {
            transitionDuration: duration,
            width: value
        };

        return (
            <div className="ui yellow progress progress-bar">
                <div className="bar" style={divStyle}></div>
            </div>
        );
    }
}

export default ProgressBar;
