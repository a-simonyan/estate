require 'jwt'

key_file = 'key.txt'
team_id = '3C94ZTB79K'
client_id = 'MIGTAgEAMBMGByqGSM49AgEGCCqGSM49AwEHBHkwdwIBAQQgOillamBqpMR4PVSEGE11lNMeaXHSJZxAH0TrXJNurNqgCgYIKoZIzj0DAQehRANCAAS+FR4BGQl+owWYbvM7r6hZJRPEMt5GbH9m+78XljV70Kz9hTBLWOf3tl7rUCT7sU+2jPRw6gFq3udN/2Pb0EkL'
key_id = 'SRJDN9TS3U'

ecdsa_key = OpenSSL::PKey::EC.new IO.read key_file

headers = {
  'kid' => key_id
}

claims = {
	'iss' => team_id,
	'iat' => Time.now.to_i,
	'exp' => Time.now.to_i + 86400*180,
	'aud' => 'https://appleid.apple.com',
	'sub' => client_id,
}

token = JWT.encode claims, ecdsa_key, 'ES256', headers

puts token