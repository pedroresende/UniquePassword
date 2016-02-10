/**
 * Description of add_password.js
 *
 * @author Pedro Resende <pedroresende@mail.resende.biz>
 */

var Year = React.createClass({
   render: function () {
       return (
        <option value={this.props.data}>
            {this.props.data}
        </option>
        )
   } 
});

var Years = React.createClass({
    render: function () {
        var today = new Date();
        var year = today.getFullYear();
        var years = [];
        for (var i=year; i < year+10; i++) {
            years.push(<Year key={i} data={i}/>);
        }
        return (
            <div>
                <select id="year">
                    {years}
                </select>
            </div>
        )
    }
});

var LoginForm = React.createClass ({
    render: function() {
        return (
            <div>
                <div className="form-group">
                    <label htmlFor="usernameInput">Username</label>
                    <input type="text" className="form-control" id="usernameInput" ref="usernamename" placeholder="Username" />
                </div>
                <div className="form-group">
                    <label htmlFor="passwordInput">Password</label>
                    <input type="text" className="form-control" id="passwordInput" ref="passwordname" placeholder="Password" />
                </div>
                <div className="form-group">
                    <label htmlFor="sitenameInput">Site Name</label>
                    <input type="text" className="form-control" id="sitenameInput" ref="sitename" placeholder="http://..." />
                </div>
            </div>
        );
    }
});

var CreditCardForm = React.createClass ({
    render: function() {
        return (
            <div>
                <div className="form-group">
                    <label htmlFor="usernameInput">Name</label>
                    <input type="text" className="form-control" id="usernameInput" ref="usernamename" placeholder="Name" />
                </div>
                <div className="form-group">
                    <label htmlFor="numberInput">Credit Card Number</label>
                    <input type="text" className="form-control" id="numberInput" ref="number" placeholder="Credit Card Number" />
                </div>
                <div className="form-group">
                    <label htmlFor="dateInput">End Date</label>
                    <Years/>
                    <input type="date" className="form-control" id="dateMonthInput" ref="date" placeholder="Month" />
                </div>
            </div>
        );
    }
});

var CategoryList = React.createClass({
  render: function() {
    return (
        <option value={this.props.data.id}>
            {this.props.data.name}
        </option>
    );
  }
});

var CategoryContent = React.createClass({
    getInitialState: function () {
        return {
            data: [],
            contentState: "1"
        };
    },
    componentDidMount: function () {
        $.ajax({
            url: this.props.url,
            dataType: 'json',
            cache: false,
            success: function(data) {
                this.setState({data: data});
            }.bind(this),
            error: function(data, status, err) {
                console.log(this.props.url, status, err.toString());
            }.bind(this)
        });
    },
    handleChange: function(event) {
        this.setState({contentState: event.target.value});
    },
    render: function () {
        var categories = this.state.data.map(function (category) {
            return (
                    <CategoryList key={category.id} data={category} />
                );
        });
        var content;
        if (this.state.contentState == 1) {
            content = <LoginForm/>;
        } else {
            if (this.state.contentState == 2) {
                content = <CreditCardForm/>;
            } else {
                content = <NotesForm/>;
            } 
        }
        return (
            <form onSubmit={this.handleSubmit}>
                <div className="form-group">
                    <label htmlFor="nameInput">Name</label>
                    <input type="text" className="form-control" id="nameInput" ref="name" placeholder="Name" />
                </div>
                <div className="form-group">
                    <label htmlFor="exampleInputPassword1">Category</label>
                    <select className="form-control" onChange={this.handleChange}>
                        {categories}
                    </select>
                </div>
                {content}
               <button type="submit" className="btn btn-default">Submit</button>
            </form>
        );
    }
});
      
ReactDOM.render(
  <CategoryContent url="http://localhost:8000/categories/get"/>,
  document.getElementById('add_password')
);