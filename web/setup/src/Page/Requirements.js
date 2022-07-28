import Badge from 'react-bootstrap/Badge';
import ListGroup from 'react-bootstrap/ListGroup';
import Button from 'react-bootstrap/Button';
import Col from 'react-bootstrap/Col';
import Row from 'react-bootstrap/Row';
import Alert from 'react-bootstrap/Alert';
import {LinkContainer} from 'react-router-bootstrap'
import {
    BsCheck2All,
    BsFillExclamationDiamondFill,
    BsFillArrowLeftSquareFill,
    BsFillArrowRightSquareFill,
    BsArrowRepeat
} from "react-icons/bs";
import {Component} from "react";


export default class Requirements extends Component {

    constructor(props) {
        super(props);
        this.state = {
            error: {
                message: null
            },
            isLoaded: false,
            phpVersionRequirements: {
                required: null,
                installed_version: null,
                passed: false
            },
            installable: false,
            requirements: []
        }
    }

    componentDidMount() {
        fetch("http://localhost:3333/setup/index.php?page=requirement")
            .then(res => {
                return res.json()
            })
            .then((result) => {
                    console.log()
                    this.setState({
                        isLoaded: true,
                        phpVersionRequirements: result.phpVersionRequirements,
                        installable: result.installable,
                        requirements: result.system_requirements
                    })
                },
                (error) => {
                    this.setState({
                        isLoaded: true,
                        error: {
                            message: error
                        }
                    })
                })
    }

    pageReload() {
        window.location.reload();
    }

    render() {
        const {error, isLoaded, requirements, phpVersionRequirements, installable} = this.state;
        if (error.message !== null) {
            return <Row>
                <Col>
                    <Alert key="danger" variant="danger">
                        {error.message}
                    </Alert>
                </Col>
            </Row>
        } else if (isLoaded === false) {
            return <Row>
                <Col>
                    <Alert key="info" variant="info">
                        Loading..
                    </Alert>
                </Col>
            </Row>
        } else {
            return <Row>
                <Col>
                    <div className="p-5">
                        <div className="mb-5">
                            <span className="badge bg-secondary">Step 2</span>
                            <h3 className="h4 font-weight-bold text-theme">System Requirements</h3>
                        </div>
                        <p>Requirements List</p>
                        <ListGroup as="ol">

                            <ListGroup.Item
                                as="li" key="required_php"
                                className="d-flex justify-content-between align-items-start"
                            >
                                <div className="ms-2 me-auto">
                                    <div className="fw-bold">Required PHP
                                        Version: {phpVersionRequirements.required}
                                    </div>
                                </div>
                                <Badge bg="primary" className="ms-2" pill>
                                    Installed Version: {phpVersionRequirements.installed_version}
                                </Badge>&nbsp;
                                <Badge bg="primary" pill>
                                    {phpVersionRequirements.passed ? <BsCheck2All/> : <BsFillExclamationDiamondFill/>}
                                </Badge>
                            </ListGroup.Item>
                            {requirements.map(item => (

                                <ListGroup.Item
                                    as="li" key={item.name}
                                    className="d-flex justify-content-between align-items-start"
                                >
                                    <div className="ms-2 me-auto">
                                        <div className="fw-bold">{item.name}</div>
                                    </div>

                                    <Badge bg="primary" pill>
                                        {item.passed ? <BsCheck2All/> : <BsFillExclamationDiamondFill/>}
                                    </Badge>
                                </ListGroup.Item>

                            ))}

                        </ListGroup>

                        {installable ?
                            <p className="text-success mt-2 mb-5">Congratulations! Everything looks good, you can now
                                install the software. </p>
                            :
                            <p className="text-danger mt-2 mb-5">Ups, the system requirements are not met, please try
                                again
                                after completing the required items from the list.</p>
                        }

                        <Row>
                            <Col>
                                <LinkContainer to="/">
                                    <Button variant="primary"><BsFillArrowLeftSquareFill/> Home</Button>
                                </LinkContainer>
                            </Col>
                            <Col>
                                {installable ?
                                    <LinkContainer to="/install">
                                        <Button variant="primary"><BsFillArrowRightSquareFill/> Install</Button>
                                    </LinkContainer>
                                    :
                                    <Button variant="primary" onClick={this.pageReload}>
                                        <BsArrowRepeat/> Re-Check
                                    </Button>
                                }
                            </Col>
                        </Row>
                    </div>
                </Col>
            </Row>
        }
    }
}