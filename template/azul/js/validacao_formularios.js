$(document).ready( function() {

    // Cadastro de Usuário

    $("#formularioUsuarios").validate({

        rules:{
            usuario:{
                required: true,
                minlength: 2,
                maxlength: 8
            },
            nome_completo:{
                required: true,
                minlength: 5
            },
            senha:{
                required: true,
                minlength: 4
            },
            senha2:{
                required: true,
                minlength: 4,
                equalTo: "#senha"
            },
            email:{
                required: true,
                email: true
            }
        },

        messages:{
            usuario:{
                required: "Usuário obrigatório!",
                minlength: "O seu login deve conter, no mínimo, 2 caracteres",
                maxlengt: "O seu login deve conter, no máximo, 8 caracteres"
            },
            nome_completo:{
                required: "Nome completo obrigatório!",
                minlength: "O seu nome deve conter, no mínimo, 5 caracteres"
            },
            senha:{
                required: "Senha obrigatória!",
                minlength: "sua senha deve conter no mínimo, 4 caracteres"
            },
            senha2:{
                required: "Confirmação obrigatória!",
                minlength: "Confirmação deve conter no mínimo, 4 caracteres",
                equalTo: "Senhas diferentes!"
            },
            email:{
                required: "Email Obrigatório",
                email: "Digite um e-mail válido"
            }
        }
    });

    // Cadastro de Taxas

    $("#formularioTaxas").validate({

        rules:{
            descricao:{
                required: true
            },
            abreviacao:{
                required: true,
                maxlength: 5
            }
        },

        messages:{
            descricao:{
                required: "Nome da taxa obrigatório!"
            },
            abreviacao:{
                required: "Abreviação da taxa obrigatória!",
                maxlength: "Campo com no máximo 5 caracteres"

            }
        }
    });

    // Cadastro de Valores de Taxas

    $("#formularioNegociacao").validate({

        rules:{
            valor:{
                required: true
            }
        },

        messages:{
            valor:{
                required: "Campo valor obrigatório!"
            }
        }
    });

    // Cadastro de Estados

    $("#formularioEstados").validate({

        rules:{
            uf:{
                required: true,
                maxlength: 2,
                minlength: 2
            },
            estado:{
                required: true,
                minlength: 3
            }
        },

        messages:{
            uf:{
                required: "Campo UF obrigatório!",
                maxlength: "Sua UF deve conter exatamente, 2 caracteres",
                minlength: "Sua UF deve conter exatamente, 2 caracteres"
            },
            estado:{
                required: "Campo Obrigatório",
                minlength: "O Nome do estado deve conter no minimo, 3 caracteres"
            }
        }
    });

    // Cadastro de Cidades

    $("#formularioCidades").validate({

        rules:{
            nome:{
                required: true,
                minlength: 2
            },
            distancia:{
                required: true
            }
        },

        messages:{
            nome:{
                required: "Campo Nome obrigatório!",
                minlength: "O Nome da Cidade deve conter no minimo, 2 caracteres"
            },
            distancia:{
                required: "Campo Obrigatório"
            }
        }
    });

    // Cadastro de Bases

    $("#formularioBases").validate({

        rules:{
            cidade:{
                required: true
            },
            sigla:{
                required: true,
                minlength: 3,
                maxlength: 3
            }
        },

        messages:{
            cidade:{
                required: "Campo Cidade obrigatório!"
            },
            sigla:{
                required: "Campo Obrigatório"
            }
        }
    });

    // Cadastro de Representantes

    $("#formularioRepresentantes").validate({

        rules:{
            representante:{
                required: true,
                minlength: 2
            },
            cidade:{
                required: true
            },
            tipo_pessoa:{
                required: true
            },
            cpf_cnpj:{
                required: true
            },
            endereco:{
                required: true
            },
            numero:{
                required: true
            },
            bairro:{
                required: true,
                minlength: 2
            },
            cep:{
                required: true
            },
            ie:{
                required: true
            }
        },

        messages:{
            representante:{
                required: "Preenchimento Obrigatório",
                minlength: "O Representante deve conter no mínimo, 2 caracteres"
            },
            cidade:{
                required: "Preenchimento Obrigatório"
            },
            tipo_pessoa:{
                required: "Preenchimento Obrigatório"
            },
            cpf_cnpj:{
                required: "Preenchimento Obrigatório"
            },
            endereco:{
                required: "Preenchimento Obrigatório"
            },
            numero:{
                required: "Preenchimento Obrigatório"
            },
            bairro:{
                required: "Preenchimento Obrigatório",
                minlength: "O Bairro deve conter no mínimo, 2 caracteres"
            },
            cep:{
                required: "Preenchimento Obrigatório"
            },
            ie:{
                required: "Preenchimento Obrigatório"
            }
        }
    });

    // Cadastro de Módulos

    $("#formularioModulos").validate({

        rules:{
            controlador:{
                required: true
            },
            metodo:{
                required: true
            },
            texto_menu:{
                required: true
            },
            menu_pai:{
                required: true
            }
        },

        messages:{
            controlador:{
                required: "Preenchimento Obrigatório"
            },
            metodo:{
                required: "Preenchimento Obrigatório"
            },
            texto_menu:{
                required: "Preenchimento Obrigatório"
            },
            menu_pai:{
                required: "Preenchimento Obrigatório"
            }
        }
    });

    // Edição de Serviços (Coletas e Entregas em Relatorios)
    
    $('#formularioServicos').submit(function(){
       
        var erros = 0;
       
        $('input.obrigatorio').each(function(i){
            
            if ( $(this).val() == '' || $(this).val() == null ) {
                
                $(this).css('border','1px solid red');
                erros++;
            } 
       });
       
       if ( erros > 0 ) { return false; } else { return true; }
    });
    

    /*$("#formularioServicos").validate({

        rules:{
            minuta:{
                required: true
            },
            entregador:{
                required: true
            },
            recebedor:{
                required: true
            },
            setor:{
                required: true
            },
            data_coleta:{
                required: true
            },
            hora_coleta:{
                required: true
            },
            data_entrega:{
                required: true
            },
            hora_entrega:{
                required: true
            },
            cia_aerea:{
                required: true
            },
            conhecimento_aereo:{
                required: true
            },
            peso:{
                required: true
            }
        },

        messages:{
            minuta:{
                required: "Preenchimento Obrigatório"
            },
            entregador:{
                required: "Preenchimento Obrigatório"
            },
            recebedor:{
                required: "Preenchimento Obrigatório"
            },
            setor:{
                required: "Preenchimento Obrigatório"
            },
            data_coleta:{
                required: "Preenchimento Obrigatório"
            },
            hora_coleta:{
                required: "Preenchimento Obrigatório"
            },
            data_entrega:{
                required: "Preenchimento Obrigatório"
            },
            hora_entrega:{
                required: "Preenchimento Obrigatório"
            },
            cia_aerea:{
                required: "Preenchimento Obrigatório"
            },
            conhecimento_aereo:{
                required: "Preenchimento Obrigatório"
            },
            peso:{
                required: "Preenchimento Obrigatório"
            }
        }
    }); */

    // Cadastro de Cidades

    $("#servicosEditaAdmin").validate({

        rules:{
            peso_cia_aerea:{
                number: true,
                maxlength: 6
            }
        },

        messages:{
            peso_cia_aerea:{
                number: "Somente Valores NumÃ©ricos",
                maxlength: "Máximo de 6 nÃºmeros."
            }
        }
    });
    
    
    // Formulário Alteração de Senhas

    $("#formularioAlterarSenha").validate({

        rules:{
            senha_atual:{
                required: true
            },
            nova_senha:{
                required: true,
                minlength: 4
            },
            repete_senha:{
                required: true,
                minlength: 4,
                equalTo: "#nova_senha"
            }
        },

        messages:{
            senha_atual:{
                required: "Preenchimento Obrigatório"
            },
            nova_senha:{
                required: "Senha obrigatória!",
                minlength: "sua senha deve conter no mínimo, 4 caracteres"
            },
            repete_senha:{
                required: "Confirmação obrigatória!",
                minlength: "Confirmação deve conter no mínimo, 4 caracteres",
                equalTo: "Senhas diferentes!"
            }
        }
    });
    
    // Validação Serviços Admin

    $("#formularioServicosEditaAdmin").validate({

        rules:{
            previsao_pagamento:{
                required: true
            },
            qtde_coleta:{
                number: true,
                minlength: 1,
                maxlength: 1
            }
        },

        messages:{
            previsao_pagamento:{
                required: "Campo Previs&atilde;o de Pagamento Obrigat&oacute;rio!"
            },
            qtde_coleta:{
                number: "Use somente Numeros!",
                minlength: "Minimo de um Numero!",
                maxlength: "Maximo de um Numero"
            }
        }
    });
    

});