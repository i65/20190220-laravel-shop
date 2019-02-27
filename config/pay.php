<?php

return [
    'alipay' => [
        'app_id' => '2016092700606998',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA0Q/s5P3fnlfPqOa+NufeyKpx8DFkc3WfLgdbEatqpf0s3nEYR+ODU+Oz0Zfn/zFnu/WRYcI5tvQzZ63Hl8zvDi7DcwnxYrL/dixPzzLT2tMOwVqLXzKqhZO0g1goJ4Uu+oollq1q8r0eEiGgU8ivce/XnWKbrog8wFHg+xh2vd5e+LhlF7WDLubtPcdafHRed+CWxpYkpe6JjFDm1PYkSIadEK4vM/Ryn/N1NT+SgMTxzbx8o6gYM245+4IYxRgXMe5hDJLvFuBUt7K1i2VMNyuZ7YzpLLDeUaBb4PMNKcHeRwcSHZhQBdk2CS+jiO5eo8tgNbi8u+bkjDAafPaNhQIDAQAB',
        'private_key' => 'MIIEogIBAAKCAQEAwUxi0nNadi8uHMeAIpJFqn12XvkvP/8w2vo4fxQhtXVt6XbHWbudTBFUH8B7j/bHeApPLPGrxGjUbOeneSzwrPGG0UHTJ8eOVUMukcMAy9CrvwXzFvEZ9gCDWvNJkgoQqJZk2J/5gYR5u0maHZxM0fXlnVLzcdUPkNYipCMAPKbFMn5a5JdO/0Er0QVuN1G7B3pJARW3+LPFIl1NStl/0Z3SQnEjhnstqbW2I8G3kIzRrn8QLC2oPt3aa0DFWZvXkYacwvoG840HztiYEXHpwIw7+4AR3zVGrLpeW2CKx7V0TsHBHbbDZlPjc0L4oFVUZh75HnD8AtyRa+9E6w8SpwIDAQABAoIBAAgOEdQpQGzKXIaQfbNzGvoWzlb41VI6ZSPK543MHfd81D61V2tS2SQxWKsWD1AZfYhwDYqW64x8vdVn9d+j0seyLOcNcionM7Qz333tfVwA7xc/vTiIhYdt0At7NeajCryrv7oTOIeAKL54O7beK4lYUOA0c7abpVFoyvrCBqGAUw72EGiTf72FjCyBMX+oTREl5vDJVicxpMcmDt/Kzvz2n07CruZPkKbsGVztkKs3D6UoMLYmQ2OeQUjn9ESYGiEI0kxEF9lh77JtqXOHp2uQSp0JCBCZbiEJ9R+Kott8LdxV+UiDBA7D74poI+QzTZANb8yTQTpxMP293hCTPOECgYEA4I6FJKamlhWKxLFh+fAafd4ptWxiMZdHZbAIjsjk8nD4BiDcXJFoPrgXrP5v18fMCONy8EuNyhpLkHzE+LgQ8EurYxMOgoHuMwndGDpUWysw0IeKymTN+RcAaKYj3JorblcsHvWS/CgT0UyFjsKxwSoejhkx8uCuHSIrHl37U/ECgYEA3F1geiRzvTkVA3l/1U/Dx2I3ijx3obPWrMzl2Wy01KPlC6Zo2HyrixELBuS9nhgUyYXKPReOwcBN9mU6Wn/zEqk5TsUpd76ZkwZI2E+/QrqBLgYJPHObonfQ0RpnS0W4ZDhHlbzf87Icm+o29ukOjZOlsWrCkb0vidqzA7uLCBcCgYBuRM4Qv10SWiW4jLpl94eqw0uL8VsOqxC+WID7TJ9QhjTlHYHYWvbrxY6qvo7BUTVaMAajBRbtZZgxrXM0B38Z4K6aiiMX5yHHIlLVsN73ne/sloKK/JFAfhEPUnZNv88P8fKSiVjSRgPlRURYZDbRehNjB/BFKhuV5s9xrAjcoQKBgCEUa10qh61KGltxK71rwen2VnwL47GEe59pCr/+z450I/gBvQ9yd5XisxMP118aIlS2HsvY83cmVQ292GqpdmXAvXeTpUvycr9dXCYMoptzv9yWz2AhwqU68z/QhN0J1EpHIIfb2IqOnDjTifi6t5KNLXxamGakTbSV/fV7e711AoGATvaz+GaHxQ6ziCUjR5WEUIs1/HCgNKBQ8r/kN9KPUEYd0Hw3D7dvEpV4+nRabdUTXfjKDAr/ckaWfLN5vslBY72WID8cBeSvIROgQ24d/O5iJlmbhHwZsR8HCRkyy3BBlVhDFTtClz5R46WGf1Iilquqf2KfVG71LGqeME4xCos=',
        'log' => [
            'file' => storage_path('logs/alipay.log'),
        ],
    ],

    'wechat' => [
        'app_id' => '',
        'mch_id' => '',
        'key' => '',
        'cert_client' => '',
        'cert_key' => '',
        'log' => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],
    ],
];