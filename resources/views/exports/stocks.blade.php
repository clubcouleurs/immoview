@foreach($constructibles as $header => $constructible)
                <table>
                  <thead>
                    <tr>
                      <th bgcolor="{{$color[$loop->index]}}" width="15">Tranche</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="25">Nombre de {{$header}}</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="25">{{$header}} Vendus</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="25">{{$header}} Réservés</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="25">{{$header}} Bloqués</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="25">{{$header}} En Stock</th>

                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($$constructible as $key => $data)
                    <tr>

                      <td bgcolor="{{$color[$loop->parent->index]}}" >
                          {{$key}}
                      </td>    

                      <td>
                          {{$data['total'] }}
                      </td>

                      <td>
                          {{$data['vendus'] }}

                      </td>

                      <td>
                          {{$data['reserved'] }}

                      </td>

                      <td>
                          {{$data['blocked'] }}

                      </td>
                      <td>
                          {{$data['stocked'] }}

                      </td>                        
                    </tr>

                    @endforeach

                    <!-- la ligne des totaux -->

                    <tr>

                      <td>
                          Total
                      </td>
                      <td>
                          @php
                            echo $$header['total']; 
                          @endphp
                      </td>
                      <td>
                          @php
                            echo $$header['vendus']; 
                          @endphp
                      </td>
                      <td>
                          @php
                            echo $$header['reserved']; 
                          @endphp
                      </td>

                      <td>
                          @php
                            echo $$header['blocked']; 
                          @endphp
                      </td>

                      <td>
                          @php
                            echo $$header['stocked']; 
                          @endphp
                      </td>                      

                    </tr>

                  </tbody>
                </table>

            @endforeach

