import React, {useEffect, useState} from 'react';
import GoogleMapReact from 'google-map-react';
import axios from 'axios';
import {CircularProgress} from '@mui/material';
import Alert from './map/Alert';
import {useTranslation} from 'react-i18next';

const Map = () => {
    const defaultProps = {
        center: {
            lat: 52.32,
            lng: 17.08
        },
        zoom: 4
    };
    const [googleMapApiKey, setGoogleMapApiKey] = useState('');
    const [googleMapLoader, setGoogleMapLoader] = useState(true);
    const [googleMapErrorMsg, setGoogleMapErrorMsg] = useState('');
    const [map, setMap] = useState({});
    const [maps, setMaps] = useState({});
    const [markers, setMarkers] = useState([]);
    const [loader, setLoader] = useState(false);
    const {t} = useTranslation();

    useEffect(() => {
        loadGoogleMapApiKey();
    }, []);

    const loadGoogleMapApiKey = async () => {
        await axios.get(`${origin}/api/google-map`).then((response) => {
            const googleMapApiKey = response.data;
            setGoogleMapApiKey(googleMapApiKey);
        }).catch((error) => {
            const {detail} = error.response.data;
            setGoogleMapErrorMsg(detail);
            console.error(detail);
        }).finally(() => {
            setGoogleMapLoader(false);
        });
    }

    const handleGoogleApiLoaded = (map, maps) => {
        setMap(map);
        setMaps(maps);
    };

    const handleClick = async (obj) => {
        const {lat, lng} = obj;

        if (!loader) {
            markers.forEach((marker) => {
                marker.setMap(null);
            })

            await axios.get(`${origin}/api/weather?lat=${lat}&lon=${lng}`)
                .then((response) => {
                    const {data} = response;

                    if (data['cod']) {
                        const {cod, message} = data;
                        const content = `<div class="marker-content error">
                                  <div class="data">
                                      <p>${t('history.error')}</p>
                                      <p>${t('history.status')}: ${cod}</p>
                                      <p>${message}</p>
                                  </div>
                               </div>`;

                        createInfoWindow(lat, lng, content);
                        console.error(message);
                    } else {
                        const {temperature, cloudiness, wind, description, name} = data;
                        const dateTime = new Date().toLocaleString();
                        const weatherData = {
                            temperature: temperature.toString(),
                            cloudiness: cloudiness,
                            wind: wind.toString(),
                            description: description,
                            lat: lat.toString(),
                            lng: lng.toString(),
                            city: name,
                            dateTime: dateTime
                        };

                        const content = `<div class="marker-content">
                                  <div class="data">
                                      <p>${t('history.temperature')}: ${temperature}&#8451;</p>
                                      <p>${t('history.cloudiness')}: ${cloudiness}%</p>
                                      <p>${t('history.wind')}: ${wind} m/s</p>
                                      <p>${t('history.description')}: ${description}</p>
                                  </div>
                                  <div class="status loading">${t('history.saving')}</div>
                               </div>`;
                        const infoWindow = createInfoWindow(lat, lng, content);

                        setLoader(true);

                        axios({
                            method: 'POST',
                            url: `${origin}/api/history`,
                            data: weatherData
                        }).then((response) => {
                            const {status} = response.data;

                            if (status === 200) {
                                infoWindow.setContent(`<div class="marker-content">
                                                      <div class="data">
                                                          <p>${t('history.temperature')}: ${temperature}&#8451;</p>
                                                          <p>${t('history.cloudiness')}: ${cloudiness}%</p>
                                                          <p>${t('history.wind')}: ${wind} m/s</p>
                                                          <p>${t('history.description')}: ${description}</p>
                                                      </div>
                                                      <div class="status">${t('history.saved')}</div>
                                                  </div>`);
                            } else {
                                console.error(status);
                            }

                            setLoader(false);
                        }).catch((response) => {
                            console.error(response);
                        });
                    }
                });
        }
    }

    const createInfoWindow = (lat, lng, content) => {
        const marker = new maps.Marker({
            position: {lat, lng},
            map
        });
        const infoWindow = new maps.InfoWindow({
            content: content
        });

        markers.push(marker);
        map.panTo(marker.getPosition());
        infoWindow.open(map, marker);

        setMarkers(markers);

        return infoWindow;
    }

    return (
        <div className="map">
            {
                googleMapLoader ?
                    <CircularProgress/> :
                    (
                        googleMapErrorMsg ?
                            <Alert message={googleMapErrorMsg}/> :
                            <GoogleMapReact
                                bootstrapURLKeys={{key: googleMapApiKey}}
                                defaultCenter={defaultProps.center}
                                defaultZoom={defaultProps.zoom}
                                onClick={handleClick}
                                yesIWantToUseGoogleMapApiInternals
                                onGoogleApiLoaded={({map, maps}) => handleGoogleApiLoaded(map, maps)}
                            >
                            </GoogleMapReact>
                    )
            }
        </div>
    );
}

export default Map;
