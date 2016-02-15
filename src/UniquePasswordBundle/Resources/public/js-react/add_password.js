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
                <select id="year" name="creditcardYear" ref="creditcardYear">
                    {years}
                </select>
            </div>
        )
    }
});

var Month = React.createClass({
   render: function () {
       return (
        <option value={this.props.data}>
            {this.props.data}
        </option>
        )
   } 
});

var Months = React.createClass({
    render: function () {
        var months = [];
        for (var i=1; i <= 12; i++) {
            months.push(<Month key={i} data={i}/>);
        }
        return (
            <div className="month">
                <select id="month" name="creditcardMonth" ref="creditcardMonth">
                    {months}
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
                    <input type="text" className="form-control" id="usernameInput" name="siteUsername" ref="siteUsername" placeholder="Username" required/>
                </div>
                <div className="form-group">
                    <label htmlFor="passwordInput">Password</label>
                    <input type="password" className="form-control" id="passwordInput" name="sitePassword" ref="sitePassword" required/>
                </div>
                <div className="form-group">
                    <label htmlFor="sitenameInput">Site Name</label>
                    <input type="text" className="form-control" id="sitenameInput" name="siteSitename" ref="siteSitename" placeholder="http://..." required/>
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
                    <input type="text" className="form-control" id="usernameInput" name="creditcardName" ref="creditcardName" placeholder="Name" required/>
                </div>
                <div className="form-group">
                    <label htmlFor="numberInput">Credit Card Number</label>
                    <input type="text" className="form-control" id="numberInput" name="creditcardNumber" ref="creditcardNumber" placeholder="Credit Card Number" required/>
                </div>
                <div className="form-group">
                    <label htmlFor="dateInput">End Date</label>
                    <div className="containerDate">
                    <Months/><Years/>
                    </div>
                </div>
            </div>
        );
    }
});

var NoteForm = React.createClass ({
    componentDidMount: function() {
        $('.note').wysihtml5();
    },
    render: function() {
        return (
            <div>
                <div className="form-group">
                    <label htmlFor="noteNote">Note</label>
                    <textarea rows="8" cols="50" className="form-control note" id="noteInput" ref="noteNote" name="noteNote" placeholder="Note" required></textarea>
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
    handleSubmit: function(e) {
        e.preventDefault();
        var name = this.refs.name.value.trim();
        var category = this.refs.category.value.trim();
        if (category == 1) {
            var siteUsername = this.refs.loginform.refs.siteUsername.value;
            var sitePasword = this.refs.loginform.refs.sitePassword.value;
            var siteSitename = this.refs.loginform.refs.siteSitename.value;
            var senddata = {'name': name,'category': category, 'siteUsername': siteUsername, 'sitePasword': sitePasword, 'siteSitename': siteSitename};
        } else {
            if (category == 2) {                
                var creditcardName = this.refs.creditcardform.refs.creditcardName.value;
                var creditcardNumber = this.refs.creditcardform.refs.creditcardNumber.value;
                var creditcardMonth = this.refs.creditcardform.refs.creditcardMonth.value;
                var creditcardYear = this.refs.creditcardform.refs.creditcardYear.value;
                var senddata = {'name': name,'category': category, 'creditcardName': creditcardName, 'creditcardNumber': creditcardNumber, 'creditcardMonth': creditcardMonth, 'creditcardYear': creditcardYear};
            } else {
                var siteUsername = this.refs.noteform.refs.noteNote.value;
                var senddata = {'name': name,'category': category, 'noteNote': noteNote};
            } 
        }
        $.ajax({
            url: "/password/add",
            type: "POST",
            data: JSON.stringify({ senddata: senddata }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data){alert(data);},
            failure: function(errMsg) {
                alert(errMsg);
            }
        });
    },
    render: function () {
        var categories = this.state.data.map(function (category) {
            return (
                    <CategoryList key={category.id} data={category} />
                );
        });
        var content;
        if (this.state.contentState == 1) {
            content = <LoginForm ref="loginform"/>;
        } else {
            if (this.state.contentState == 2) {
                content = <CreditCardForm ref="creditcardform"/>;
            } else {
                content = <NoteForm ref="noteform"/>;
            } 
        }
        return (
            <form onSubmit={this.handleSubmit}>
                <div className="form-group">
                    <label htmlFor="nameInput">Name</label>
                    <input type="text" className="form-control" id="nameInput" ref="name" name="name" placeholder="Name" required/>
                </div>
                <div className="form-group">
                    <label htmlFor="exampleInputPassword1">Category</label>
                    <select className="form-control" onChange={this.handleChange} name="categoy" ref="category" required>
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
  <CategoryContent url="/categories/get"/>,
  document.getElementById('add_password')
);